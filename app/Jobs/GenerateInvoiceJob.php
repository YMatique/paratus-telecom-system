<?php

namespace App\Jobs;

use App\Models\Subscription;
use App\Services\InvoiceGenerationService;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class GenerateInvoiceJob implements ShouldQueue
{

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $subscription;
    public $referenceDate;

    /**
     * Número máximo de tentativas
     */
    public $tries = 3;

    /**
     * Timeout em segundos
     */
    public $timeout = 60;

    /**
     * Create a new job instance.
     */
    public function __construct(Subscription $subscription, Carbon $referenceDate = null)
    {
        $this->subscription = $subscription;
        $this->referenceDate = $referenceDate ?? now();

        // Configurar queue específica para faturamento
        $this->onQueue('invoices');
    }

    /**
     * Execute the job.
     */
        public function handle(InvoiceGenerationService $invoiceService): void
    {
        try {
            Log::info("Iniciando geração de fatura para subscrição {$this->subscription->id}");
            
            $invoice = $invoiceService->generateInvoiceForSubscription(
                $this->subscription, 
                $this->referenceDate
            );
            
            if ($invoice) {
                Log::info("Fatura {$invoice->invoice_number} gerada com sucesso via job para subscrição {$this->subscription->id}");
            } else {
                Log::warning("Fatura não foi gerada para subscrição {$this->subscription->id} - possivelmente já existe");
            }
            
        } catch (\Exception $e) {
            Log::error("Erro no job de geração de fatura para subscrição {$this->subscription->id}: {$e->getMessage()}");
            
            // Re-lançar exceção para que o job seja marcado como falhou
            throw $e;
        }
    }
       /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error("Job de geração de fatura falhou para subscrição {$this->subscription->id}: {$exception->getMessage()}");
        
        // Aqui você pode adicionar lógica adicional como:
        // - Enviar notificação para administradores
        // - Criar ticket de suporte automático
        // - Marcar subscrição para revisão manual
        
        // Exemplo: Adicionar nota na subscrição
        $this->subscription->update([
            'notes' => ($this->subscription->notes ?? '') . "\nERRO FATURAMENTO: " . $exception->getMessage() . " em " . now()->format('d/m/Y H:i')
        ]);
    }

    /**
     * Determinar tags para o job (útil para monitoramento)
     */
    public function tags(): array
    {
        return [
            'invoice-generation',
            'subscription:' . $this->subscription->id,
            'customer:' . $this->subscription->customer_id,
            'month:' . $this->referenceDate->format('Y-m')
        ];
    }
}
