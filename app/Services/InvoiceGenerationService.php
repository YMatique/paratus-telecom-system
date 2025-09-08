<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class InvoiceGenerationService
{
    public function generateInvoiceForSubscription(Subscription $subscription, Carbon $referenceDate = null): ?Invoice
    {
        $referenceDate = $referenceDate ?? now();

        try {
            return DB::transaction(function () use ($subscription, $referenceDate) {
                // Verificar se já existe fatura para este período
                if ($this->invoiceAlreadyExists($subscription, $referenceDate)) {
                    Log::info("Fatura já existe para subscrição {$subscription->id} no período");
                    return null;
                }

                // Carregar relacionamentos necessários
                $subscription->load(['customer', 'plan']);

                // Calcular período de faturamento
                $billingPeriod = $this->calculateBillingPeriod($subscription, $referenceDate);

                // Gerar número da fatura
                $invoiceNumber = $this->generateInvoiceNumber($referenceDate);

                // Calcular valores
                $subtotal = $subscription->monthly_price;
                $taxAmount = $subtotal * 0.17; // IVA 17%
                $totalAmount = $subtotal + $taxAmount;

                // Criar fatura
                $invoice = Invoice::create([
                    'invoice_number' => $invoiceNumber,
                    'customer_id' => $subscription->customer_id,
                    'subscription_id' => $subscription->id,
                    'issue_date' => $referenceDate->toDateString(),
                    'due_date' => $this->calculateDueDate($subscription, $referenceDate),
                    'subtotal' => $subtotal,
                    'tax_amount' => $taxAmount,
                    'discount_amount' => 0,
                    'total_amount' => $totalAmount,
                    'status' => 'pending',
                    'notes' => "Fatura automática - Período: {$billingPeriod['description']}"
                ]);

                // Criar item da fatura
                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'description' => $this->generateItemDescription($subscription, $billingPeriod),
                    'quantity' => 1,
                    'unit_price' => $subscription->monthly_price,
                    'total_price' => $subscription->monthly_price,
                    'type' => 'plan'
                ]);

                // Atualizar subscrição
                $this->updateSubscriptionAfterInvoicing($subscription, $referenceDate);

                Log::info("Fatura {$invoiceNumber} gerada com sucesso para subscrição {$subscription->id}");

                return $invoice;
            });
        } catch (\Exception $e) {
            Log::error("Erro ao gerar fatura para subscrição {$subscription->id}: {$e->getMessage()}");
            throw $e;
        }
    }

    /**
     * Verificar se já existe fatura para o período
     */
    private function invoiceAlreadyExists(Subscription $subscription, Carbon $referenceDate): bool
    {
        return Invoice::where('subscription_id', $subscription->id)
            ->whereMonth('issue_date', $referenceDate->month)
            ->whereYear('issue_date', $referenceDate->year)
            ->where('status', '!=', 'cancelled')
            ->exists();
    }

    /**
     * Calcular período de faturamento
     */
    private function calculateBillingPeriod(Subscription $subscription, Carbon $referenceDate): array
    {
        $billingDay = $subscription->billing_day ?? 1;

        // Calcular início do período (dia de vencimento do mês anterior ou atual)
        $periodStart = $referenceDate->copy()->day($billingDay);

        // Se o dia de cobrança ainda não passou este mês, o período é do mês anterior
        if ($referenceDate->day < $billingDay) {
            $periodStart->subMonth();
        }

        $periodEnd = $periodStart->copy()->addMonth()->subDay();

        return [
            'start' => $periodStart,
            'end' => $periodEnd,
            'description' => $periodStart->format('d/m/Y') . ' a ' . $periodEnd->format('d/m/Y')
        ];
    }

    /**
     * Gerar número da fatura
     */
    private function generateInvoiceNumber(Carbon $date): string
    {
        $year = $date->year;
        $month = $date->format('m');

        // Buscar último número sequencial do mês
        $lastInvoice = Invoice::whereYear('issue_date', $year)
            ->whereMonth('issue_date', $month)
            ->orderBy('id', 'desc')
            ->first();

        $sequence = 1;
        if ($lastInvoice) {
            // Extrair número da última fatura e incrementar
            $lastNumber = $lastInvoice->invoice_number;
            if (preg_match('/INV-\d{6}-(\d+)/', $lastNumber, $matches)) {
                $sequence = intval($matches[1]) + 1;
            }
        }

        return "INV-{$year}{$month}-" . str_pad($sequence, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Calcular data de vencimento
     */
    private function calculateDueDate(Subscription $subscription, Carbon $issueDate): string
    {
        $dueDate = $issueDate->copy();

        // Usar dia de vencimento da subscrição
        $billingDay = $subscription->billing_day ?? 1;

        // Se já passou o dia de vencimento neste mês, vence no próximo mês
        if ($issueDate->day >= $billingDay) {
            $dueDate->addMonth()->day($billingDay);
        } else {
            $dueDate->day($billingDay);
        }

        // Garantir que não vence em fim de semana (mover para segunda)
        if ($dueDate->isWeekend()) {
            $dueDate->next(Carbon::MONDAY);
        }

        return $dueDate->toDateString();
    }

    /**
     * Gerar descrição do item
     */
    private function generateItemDescription(Subscription $subscription, array $billingPeriod): string
    {
        $planName = $subscription->plan->name ?? 'Plano de Internet';
        $speed = '';

        if ($subscription->plan) {
            $downloadSpeed = $subscription->plan->download_speed;
            $uploadSpeed = $subscription->plan->upload_speed;
            $speed = " - {$downloadSpeed}/{$uploadSpeed} Mbps";
        }

        return "{$planName}{$speed} - {$billingPeriod['description']}";
    }

    /**
     * Atualizar subscrição após faturamento
     */
    private function updateSubscriptionAfterInvoicing(Subscription $subscription, Carbon $referenceDate): void
    {
        $billingDay = $subscription->billing_day ?? 1;

        // Calcular próxima data de faturamento
        $nextInvoiceDate = $referenceDate->copy()->addMonth();

        // Ajustar para o dia de vencimento
        $nextInvoiceDate->day($billingDay);

        // Se o dia já passou neste mês, mover para o próximo
        if ($nextInvoiceDate->isPast()) {
            $nextInvoiceDate->addMonth()->day($billingDay);
        }

        $subscription->update([
            'last_invoice_date' => $referenceDate->toDateString(),
            'next_invoice_date' => $nextInvoiceDate->toDateString()
        ]);
    }

    /**
     * Gerar faturas para múltiplas subscrições
     */
    public function generateInvoicesForSubscriptions($subscriptions, Carbon $referenceDate = null): array
    {
        $results = [
            'success' => 0,
            'errors' => 0,
            'total_amount' => 0,
            'invoices' => []
        ];

        foreach ($subscriptions as $subscription) {
            try {
                $invoice = $this->generateInvoiceForSubscription($subscription, $referenceDate);

                if ($invoice) {
                    $results['success']++;
                    $results['total_amount'] += $invoice->total_amount;
                    $results['invoices'][] = $invoice;
                }
            } catch (\Exception $e) {
                $results['errors']++;
                Log::error("Erro ao processar subscrição {$subscription->id}: {$e->getMessage()}");
            }
        }

        return $results;
    }

    /**
     * Marcar faturas como vencidas
     */
    public function markOverdueInvoices(): int
    {
        $count = Invoice::where('status', 'pending')
            ->where('due_date', '<', now()->toDateString())
            ->update(['status' => 'overdue']);

        if ($count > 0) {
            Log::info("Marcadas {$count} faturas como vencidas");
        }

        return $count;
    }

    /**
     * Suspender clientes inadimplentes
     */
    public function suspendOverdueCustomers(int $daysAfterDue = 7): int
    {
        // Buscar subscrições com faturas muito vencidas
        $subscriptionsToSuspend = Subscription::whereHas('invoices', function ($query) use ($daysAfterDue) {
            $query->where('status', 'overdue')
                ->where('due_date', '<', now()->subDays($daysAfterDue)->toDateString());
        })
            ->where('status', 'active')
            ->get();

        $count = 0;
        foreach ($subscriptionsToSuspend as $subscription) {
            $subscription->update([
                'status' => 'suspended',
                'notes' => ($subscription->notes ?? '') . "\nSuspenso por inadimplência em " . now()->format('d/m/Y H:i')
            ]);
            $count++;

            Log::info("Subscrição {$subscription->id} suspensa por inadimplência");
        }

        return $count;
    }
}
