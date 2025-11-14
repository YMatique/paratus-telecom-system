<?php

namespace App\Livewire\Customer;
use App\Models\Invoice;
use App\Models\Subscription;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Computed;
use Livewire\Component;
#[Layout('livewire.layouts.customer-portal')]
#[Title('Dashboard - Portal do Cliente')]
class Dashboard extends Component
{
     public $customer;

    public function mount()
    {
        $this->customer = Auth::guard('customer')->user();
    }

    /**
     * Subscrições ativas
     */
    #[Computed]
    public function activeSubscriptions()
    {
        return Subscription::where('customer_id', $this->customer->id)
            ->where('status', 'active')
            ->with(['plan', 'installationAddress'])
            ->orderBy('start_date', 'desc')
            ->get();
    }

    /**
     * Última fatura
     */
    #[Computed]
    public function latestInvoice()
    {
        return Invoice::whereHas('subscription', function($query) {
                $query->where('customer_id', $this->customer->id);
            })
            ->with('subscription.plan')
            ->orderBy('created_at', 'desc')
            ->first();
    }

    /**
     * Tickets abertos
     */
    #[Computed]
    public function openTickets()
    {
        return Ticket::where('customer_id', $this->customer->id)
            ->whereIn('status', ['open', 'in_progress', 'waiting_customer'])
            ->with('subscription.plan')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
    }

    /**
     * Estatísticas
     */
    #[Computed]
    public function stats()
    {
        return [
            'active_subscriptions' => Subscription::where('customer_id', $this->customer->id)
                ->where('status', 'active')
                ->count(),

            'pending_invoices' => Invoice::whereHas('subscription', function($query) {
                    $query->where('customer_id', $this->customer->id);
                })
                ->where('status', 'pending')
                ->count(),

            'open_tickets' => Ticket::where('customer_id', $this->customer->id)
                ->whereIn('status', ['open', 'in_progress', 'waiting_customer'])
                ->count(),

            'total_spent' => Invoice::whereHas('subscription', function($query) {
                    $query->where('customer_id', $this->customer->id);
                })
                ->where('status', 'paid')
                ->sum('total_amount'),
        ];
    }

    /**
     * Próxima fatura a vencer
     */
    #[Computed]
    public function nextDueInvoice()
    {
        return Invoice::whereHas('subscription', function($query) {
                $query->where('customer_id', $this->customer->id);
            })
            ->where('status', 'pending')
            ->where('due_date', '>=', now())
            ->orderBy('due_date', 'asc')
            ->first();
    }
    public function render()
    {
        return view('livewire.customer.dashboard',[
            'activeSubscriptions' => $this->activeSubscriptions,
            'latestInvoice' => $this->latestInvoice,
            'openTickets' => $this->openTickets,
            'stats' => $this->stats,
            'nextDueInvoice' => $this->nextDueInvoice,
        ]);
    }
}
