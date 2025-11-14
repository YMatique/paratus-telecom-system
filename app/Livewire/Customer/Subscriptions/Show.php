<?php

namespace App\Livewire\Customer\Subscriptions;

use App\Models\Subscription;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Computed;
use Livewire\Component;


#[Layout('livewire.layouts.customer-portal')]
#[Title('Detalhes da Subscrição - Portal do Cliente')]
class Show extends Component
{
    public $subscriptionId;
    public $customer;
    public $subscription;

    public function mount($id)
    {
        $this->subscriptionId = $id;
        $this->customer = Auth::guard('customer')->user();

        // Buscar subscrição (somente do cliente logado)
        $this->subscription = Subscription::where('customer_id', $this->customer->id)
            ->with([
                'plan',
                'installationAddress',
                'subscriptionProducts.product',
                'subscriptionProducts.equipment'
            ])
            ->findOrFail($id);
    }

    /**
     * Faturas desta subscrição
     */
    #[Computed]
    public function invoices()
    {
        return $this->subscription->invoices()
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
    }

    /**
     * Tickets relacionados
     */
    #[Computed]
    public function tickets()
    {
        return $this->subscription->tickets()
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
    }

    /**
     * Equipamentos instalados
     */
    #[Computed]
    public function equipment()
    {
        return $this->subscription->subscriptionProducts()
            ->with(['product', 'equipment'])
            ->where('is_active', true)
            ->get();
    }

    /**
     * Solicitar upgrade
     */
    public function requestUpgrade()
    {
        return $this->redirect(route('customer.plans.index', ['subscription' => $this->subscriptionId]), navigate: true);
    }

    /**
     * Abrir ticket
     */
    public function openTicket()
    {
        return $this->redirect(route('customer.tickets.create', ['subscription' => $this->subscriptionId]), navigate: true);
    }

    /**
     * Ver fatura
     */
    public function viewInvoice($invoiceId)
    {
        return $this->redirect(route('customer.invoices.show', $invoiceId), navigate: true);
    }

    /**
     * Ver ticket
     */
    public function viewTicket($ticketId)
    {
        return $this->redirect(route('customer.tickets.show', $ticketId), navigate: true);
    }

    public function render()
    {
        return view('livewire.customer.subscriptions.show',[
            'invoices' => $this->invoices,
            'tickets' => $this->tickets,
            'equipment' => $this->equipment,
        ]);
    }
}
