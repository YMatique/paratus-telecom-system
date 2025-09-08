<?php

namespace App\Console\Commands;

use App\Services\InvoiceGenerationService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class MarkOverdueInvoices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invoices:mark-overdue
                            {--suspend-days=7 : Dias após vencimento para suspender clientes}
                            {--dry-run : Simular sem fazer alterações}';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Marca faturas como vencidas e suspende clientes inadimplentes';


    /**
     * Execute the console command.
     */
    public function handle(InvoiceGenerationService $invoiceService)
    {
        $this->info('🔍 Verificando faturas vencidas...');

        $isDryRun = $this->option('dry-run');
        $suspendDays = (int) $this->option('suspend-days');

        if ($isDryRun) {
            $this->warn('⚠️  MODO SIMULAÇÃO - Nenhuma alteração será feita!');
        }

        // Marcar faturas como vencidas
        if ($isDryRun) {
            $overdueCount = \App\Models\Invoice::where('status', 'pending')
                ->where('due_date', '<', now()->toDateString())
                ->count();
            $this->info("🔍 SIMULAÇÃO: {$overdueCount} faturas seriam marcadas como vencidas");
        } else {
            $overdueCount = $invoiceService->markOverdueInvoices();
            $this->info("✅ {$overdueCount} faturas marcadas como vencidas");
        }

        // Suspender clientes inadimplentes
        if ($isDryRun) {
            $subscriptionsToSuspend = \App\Models\Subscription::whereHas('invoices', function ($query) use ($suspendDays) {
                $query->where('status', 'overdue')
                    ->where('due_date', '<', now()->subDays($suspendDays)->toDateString());
            })
                ->where('status', 'active')
                ->count();

            $this->info("🔍 SIMULAÇÃO: {$subscriptionsToSuspend} clientes seriam suspensos (>{$suspendDays} dias em atraso)");
        } else {
            $suspendedCount = $invoiceService->suspendOverdueCustomers($suspendDays);

            if ($suspendedCount > 0) {
                $this->warn("⚠️  {$suspendedCount} clientes suspensos por inadimplência (>{$suspendDays} dias)");
            } else {
                $this->info("✅ Nenhum cliente precisou ser suspenso");
            }
        }

        // Relatório resumido
        $this->displaySummaryReport($overdueCount, $suspendedCount ?? 0, $isDryRun);

        return 0;
    }

    /**
     * Exibir relatório resumido
     */
    private function displaySummaryReport($overdueCount, $suspendedCount, $isDryRun)
    {
        $this->newLine();
        $this->info('📊 RELATÓRIO DE INADIMPLÊNCIA:');
        $this->line("📋 Faturas vencidas: {$overdueCount}");
        $this->line("⚠️  Clientes suspensos: {$suspendedCount}");

        if ($isDryRun) {
            $this->warn('⚠️  SIMULAÇÃO - Nenhuma alteração foi feita!');
        } else {
            $this->info('✅ Processamento concluído!');
        }

        // Log para auditoria
        Log::info("Processamento de inadimplência - Vencidas: {$overdueCount}, Suspensos: {$suspendedCount}");
    }
}
