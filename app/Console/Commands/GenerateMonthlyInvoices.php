<?php

namespace App\Console\Commands;

use App\Models\Subscription;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class GenerateMonthlyInvoices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invoices:generate 
                            {--date= : Data específica (Y-m-d), padrão é hoje}
                            {--dry-run : Simular sem gerar faturas}
                            {--force : Forçar geração mesmo se já existirem}';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gera faturas mensais para subscrições ativas que estão vencidas';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔄 Iniciando geração de faturas mensais...');

        // Definir data de referência
        $referenceDate = $this->option('date') ?
            \Carbon\Carbon::parse($this->option('date')) :
            now();

        $isDryRun = $this->option('dry-run');
        $force = $this->option('force');

        $this->info("📅 Data de referência: {$referenceDate->format('d/m/Y')}");

        if ($isDryRun) {
            $this->warn('⚠️  MODO SIMULAÇÃO - Nenhuma fatura será gerada!');
        }

        // Buscar subscrições que precisam de fatura
        $subscriptions = $this->getSubscriptionsDueForInvoicing($referenceDate, $force);

        if ($subscriptions->isEmpty()) {
            $this->info('✅ Nenhuma subscrição precisa de faturamento hoje.');
            return 0;
        }

        $this->info("📋 Encontradas {$subscriptions->count()} subscrições para faturar:");

        // Mostrar tabela de subscrições
        $this->displaySubscriptionsTable($subscriptions);

        if (!$isDryRun && !$this->confirm('Deseja prosseguir com a geração das faturas?', true)) {
            $this->info('❌ Operação cancelada pelo usuário.');
            return 0;
        }

        // Processar subscrições
        $this->processSubscriptions($subscriptions, $isDryRun, $referenceDate);

        $this->info('✅ Processo de faturamento concluído!');

        return 0;
    }
    private function getSubscriptionsDueForInvoicing($referenceDate, $force = false)
    {
        $query = Subscription::with(['customer', 'plan'])
            ->where('status', 'active')
            ->where('auto_renew', true);

        if (!$force) {
            // Buscar subscrições onde a próxima data de fatura é hoje ou anterior
            $query->where(function($q) use ($referenceDate) {
                $q->where('next_invoice_date', '<=', $referenceDate->toDateString())
                  ->orWhereNull('next_invoice_date');
            });
        } else {
            // No modo force, buscar todas as ativas
            $this->warn('⚠️  MODO FORÇA ativado - todas as subscrições ativas serão processadas!');
        }

        return $query->orderBy('next_invoice_date')->get();
    }

    /**
     * Exibir tabela com subscrições
     */
    private function displaySubscriptionsTable($subscriptions)
    {
        $tableData = $subscriptions->map(function($subscription) {
            return [
                'ID' => $subscription->id,
                'Cliente' => substr($subscription->customer->name ?? 'N/A', 0, 25),
                'Plano' => substr($subscription->plan->name ?? 'N/A', 0, 20),
                'Valor' => 'MT ' . number_format($subscription->monthly_price, 2),
                'Próxima Fatura' => $subscription->next_invoice_date ?? 'Não definida',
                'Dia Venc.' => $subscription->billing_day ?? 1
            ];
        })->toArray();

        $this->table([
            'ID', 'Cliente', 'Plano', 'Valor', 'Próxima Fatura', 'Dia Venc.'
        ], $tableData);
    }

    /**
     * Processar subscrições
     */
    private function processSubscriptions($subscriptions, $isDryRun, $referenceDate)
    {
        $successCount = 0;
        $errorCount = 0;
        $totalAmount = 0;

        $progressBar = $this->output->createProgressBar($subscriptions->count());
        $progressBar->start();

        foreach ($subscriptions as $subscription) {
            try {
                if ($isDryRun) {
                    // Modo simulação - apenas logar
                    $this->logSimulation($subscription);
                    $successCount++;
                    $totalAmount += $subscription->monthly_price;
                } else {
                    // Gerar fatura real
                    $invoice = $this->generateInvoice($subscription, $referenceDate);
                    
                    if ($invoice) {
                        $successCount++;
                        $totalAmount += $invoice->total_amount;
                        
                        Log::info("Fatura gerada: {$invoice->invoice_number} para {$subscription->customer->name}");
                    } else {
                        $errorCount++;
                    }
                }
            } catch (\Exception $e) {
                $errorCount++;
                $this->error("Erro ao processar subscrição {$subscription->id}: {$e->getMessage()}");
                Log::error("Erro no faturamento da subscrição {$subscription->id}: {$e->getMessage()}");
            }

            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine(2);

        // Relatório final
        $this->displayFinalReport($successCount, $errorCount, $totalAmount, $isDryRun);
    }

    /**
     * Simular geração de fatura
     */
    private function logSimulation($subscription)
    {
        Log::info("SIMULAÇÃO - Fatura seria gerada para subscrição {$subscription->id} - {$subscription->customer->name} - MT " . number_format($subscription->monthly_price, 2));
    }

    /**
     * Gerar fatura real
     */
    private function generateInvoice($subscription, $referenceDate)
    {
        try {
            // Usar job para processar em background (ou processar diretamente)
            if (config('queue.default') !== 'sync') {
                // Processar via job
                GenerateInvoiceJob::dispatch($subscription, $referenceDate);
                return true; // Retorna true pois o job foi despachado
            } else {
                // Processar diretamente
                return app(\App\Services\InvoiceGenerationService::class)
                    ->generateInvoiceForSubscription($subscription, $referenceDate);
            }
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Exibir relatório final
     */
    private function displayFinalReport($successCount, $errorCount, $totalAmount, $isDryRun)
    {
        $this->info('📊 RELATÓRIO FINAL:');
        $this->line("✅ Processadas com sucesso: {$successCount}");
        
        if ($errorCount > 0) {
            $this->error("❌ Erros: {$errorCount}");
        }
        
        $this->line("💰 Valor total: MT " . number_format($totalAmount, 2));
        
        if ($isDryRun) {
            $this->warn('⚠️  SIMULAÇÃO - Nenhuma fatura foi realmente gerada!');
        } else {
            $this->info('✅ Faturas geradas com sucesso!');
        }

        // Log para auditoria
        Log::info("Faturamento executado - Sucesso: {$successCount}, Erros: {$errorCount}, Total: MT " . number_format($totalAmount, 2));
    }
}
