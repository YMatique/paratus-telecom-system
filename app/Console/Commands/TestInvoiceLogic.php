<?php

namespace App\Console\Commands;

use App\Models\Invoice;
use App\Models\Subscription;
use App\Services\InvoiceGenerationService;
use Illuminate\Console\Command;

class TestInvoiceLogic extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:invoice-logic {subscription_id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Testa a lógica de faturamento para debug';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $subscriptionId = $this->argument('subscription_id');

        if ($subscriptionId) {
            $this->testSpecificSubscription($subscriptionId);
        } else {
            $this->testAllRecentSubscriptions();
        }
    }
    private function testSpecificSubscription($subscriptionId)
    {
        $subscription = Subscription::with(['customer', 'plan'])->find($subscriptionId);

        if (!$subscription) {
            $this->error("Subscrição {$subscriptionId} não encontrada!");
            return;
        }

        $this->info("🔍 Testando subscrição {$subscriptionId}:");
        $this->displaySubscriptionInfo($subscription);

        // Verificar se tem fatura
        $invoices = Invoice::where('subscription_id', $subscriptionId)->get();
        $this->info("\n📋 Faturas existentes: {$invoices->count()}");

        foreach ($invoices as $invoice) {
            $this->line("  • {$invoice->invoice_number} - {$invoice->status} - MT {$invoice->total_amount}");
        }

        // Testar geração
        if ($this->confirm('Tentar gerar fatura?')) {
            try {
                $invoiceService = app(InvoiceGenerationService::class);
                $invoice = $invoiceService->generateInvoiceForSubscription($subscription, now());

                if ($invoice) {
                    $this->info("✅ Fatura gerada: {$invoice->invoice_number}");
                } else {
                    $this->warn("⚠️  Fatura não gerada (provavelmente já existe)");
                }
            } catch (\Exception $e) {
                $this->error("❌ Erro: {$e->getMessage()}");
            }
        }
    }

    private function testAllRecentSubscriptions()
    {
        $this->info("🔍 Verificando subscrições criadas hoje:");

        $subscriptions = Subscription::with(['customer', 'plan'])
            ->whereDate('created_at', today())
            ->get();

        if ($subscriptions->isEmpty()) {
            $this->warn("Nenhuma subscrição criada hoje.");

            // Mostrar últimas 5
            $recent = Subscription::with(['customer', 'plan'])
                ->latest()
                ->take(5)
                ->get();

            $this->info("\n📋 Últimas 5 subscrições:");
            foreach ($recent as $sub) {
                $this->line("  • ID: {$sub->id} - {$sub->customer->name} - Status: {$sub->status}");
            }
            return;
        }

        foreach ($subscriptions as $subscription) {
            $this->line("\n" . str_repeat('-', 50));
            $this->displaySubscriptionInfo($subscription);

            // Verificar faturas
            $invoiceCount = Invoice::where('subscription_id', $subscription->id)->count();
            $this->info("📋 Faturas: {$invoiceCount}");

            // Verificar elegibilidade
            if ($subscription->status === 'active' && $subscription->auto_renew) {
                $this->info("✅ Elegível para faturamento");
            } else {
                $this->warn("⚠️  NÃO elegível - Status: {$subscription->status}, Auto-renew: " . ($subscription->auto_renew ? 'Sim' : 'Não'));
            }
        }

        // Perguntar se quer tentar gerar para todas
        if ($this->confirm("\nTentar gerar faturas para todas as elegíveis?")) {
            $this->call('invoices:generate', ['--dry-run' => true]);
        }
    }

    private function displaySubscriptionInfo($subscription)
    {
        $this->info("📝 Subscrição ID: {$subscription->id}");
        $this->line("   Cliente: {$subscription->customer->name}");
        $this->line("   Plano: {$subscription->plan->name}");
        $this->line("   Status: {$subscription->status}");
        $this->line("   Auto-renovar: " . ($subscription->auto_renew ? 'Sim' : 'Não'));
        $this->line("   Preço mensal: MT " . number_format($subscription->monthly_price, 2));
        $this->line("   Dia vencimento: {$subscription->billing_day}");
        $this->line("   Próxima fatura: " . ($subscription->next_invoice_date ?? 'Não definida'));
        $this->line("   Criada em: " . $subscription->created_at->format('d/m/Y H:i'));
    }
}
