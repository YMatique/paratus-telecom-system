<?php

namespace App\Livewire\Customer\Tickets;

use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout('livewire.layouts.customer-portal')]
#[Title('Abrir Ticket - Portal do Cliente')]
class Create extends Component
{

    public $customer;

    #[Validate('required|string|max:200')]
    public $subject = '';

    #[Validate('required|string|min:20')]
    public $description = '';

    #[Validate('required|in:technical,billing,general,upgrade,complaint')]
    public $category = 'general';

    #[Validate('required|in:low,normal,high,urgent')]
    public $priority = 'normal';

    #[Validate('nullable|exists:subscriptions,id')]
    public $subscription_id = null;

    public function mount()
    {
        $this->customer = Auth::guard('customer')->user();

        // Se o cliente tem apenas uma subscrição ativa, seleciona automaticamente
        $activeSubscriptions = $this->customer->subscriptions()->where('status', 'active')->get();
        if ($activeSubscriptions->count() === 1) {
            $this->subscription_id = $activeSubscriptions->first()->id;
        }

        // Se veio com parâmetros na URL (ex: de Plans)
        if (request()->has('subject')) {
            $this->subject = request()->get('subject');
        }
        if (request()->has('subscription_id')) {
            $this->subscription_id = request()->get('subscription_id');
        }
    }

    /**
     * Buscar subscrições ativas
     */
    public function getActiveSubscriptionsProperty()
    {
        return $this->customer->subscriptions()
            ->where('status', 'active')
            ->with('plan')
            ->get();
    }

    /**
     * Criar ticket
     */
    public function createTicket()
    {
        $this->validate();

        // Validar que a subscrição pertence ao cliente (se fornecida)
        if ($this->subscription_id) {
            $subscription = $this->customer->subscriptions()->find($this->subscription_id);
            if (!$subscription) {
                $this->addError('subscription_id', 'Subscrição inválida.');
                return;
            }
        }

        // Criar ticket
        $ticket = $this->customer->tickets()->create([
            'ticket_number' => 'TKT-' . strtoupper(uniqid()),
            'subscription_id' => $this->subscription_id,
            'subject' => $this->subject,
            'description' => $this->description,
            'category' => $this->category,
            'priority' => $this->priority,
            'status' => 'open',
            'opened_at' => now(),
        ]);

        session()->flash('success', 'Ticket criado com sucesso! Nossa equipe responderá em breve.');

        return $this->redirect(route('customer.tickets.show', $ticket->id), navigate: true);
    }

    /**
     * Cancelar e voltar
     */
    public function cancel()
    {
        return $this->redirect(route('customer.tickets.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.customer.tickets.create',[
            'activeSubscriptions' => $this->activeSubscriptions,
        ]);
    }
}
