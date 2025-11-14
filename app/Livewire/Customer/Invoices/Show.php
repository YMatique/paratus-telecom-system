<?php

namespace App\Livewire\Customer\Invoices;

use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('livewire.layouts.customer-portal')]
#[Title('Detalhes da Fatura - Portal do Cliente')]
class Show extends Component
{
     public $invoiceId;
    public $customer;
    public $invoice;


    public function mount($id)
    {
        $this->invoiceId = $id;
        $this->customer = Auth::guard('customer')->user();

        // Buscar fatura (somente do cliente logado)
        $this->invoice = Invoice::whereHas('subscription', function($query) {
                $query->where('customer_id', $this->customer->id);
            })
            ->with([
                'subscription.plan',
                'subscription.installationAddress',
                'invoiceItems',
                'payments'
            ])
            ->findOrFail($id);
    }

    /**
     * Download da fatura em PDF
     */
    public function downloadPdf()
    {
        // TODO: Implementar geração de PDF
        // Por enquanto, redireciona ou mostra mensagem
        
        session()->flash('info', 'Download de PDF será implementado em breve.');
        
        // Exemplo de implementação futura:
        // return response()->download(
        //     storage_path('app/invoices/' . $this->invoice->invoice_number . '.pdf')
        // );
    }

    /**
     * Imprimir fatura
     */
    public function printInvoice()
    {
        $this->dispatch('print-invoice');
    }

    /**
     * Marcar como paga (se pagamento foi feito externamente)
     */
    public function reportPayment()
    {
        // Redirecionar para criar ticket informando o pagamento
        return $this->redirect(route('customer.tickets.create', [
            'subject' => 'Pagamento da Fatura ' . $this->invoice->invoice_number,
            'invoice_id' => $this->invoice->id
        ]), navigate: true);
    }
    public function render()
    {
        return view('livewire.customer.invoices.show');
    }
}
