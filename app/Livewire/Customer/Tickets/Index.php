<?php

namespace App\Livewire\Customer\Tickets;

use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;


#[Layout('livewire.layouts.customer-portal')]
#[Title('Meus Tickets - Portal do Cliente')]
class Index extends Component
{
    use WithPagination;

    public $customer;
    public $filterStatus = 'open'; // all, open, in_progress, waiting_customer, resolved, closed
    public $filterPriority = 'all'; // all, low, normal, high, urgent
    public $search = '';
   public $viewMode = 'cards'; // 'cards' ou 'list'
    public function mount()
    {
        $this->customer = Auth::guard('customer')->user();
    }

 

public function setViewMode($mode)
{
    $this->viewMode = $mode;
}
    /**
     * Filtrar por status
     */
    public function filterByStatus($status)
    {
        $this->filterStatus = $status;
        $this->resetPage();
    }

    /**
     * Filtrar por prioridade
     */
    public function filterByPriority($priority)
    {
        $this->filterPriority = $priority;
        $this->resetPage();
    }

    /**
     * Limpar busca
     */
    public function clearSearch()
    {
        $this->search = '';
        $this->resetPage();
    }

    /**
     * Buscar tickets
     */
    #[Computed]
    public function tickets()
    {
        $query = Ticket::where('customer_id', $this->customer->id)
            ->with(['subscription.plan', 'assignedTo']);

        // Filtro de status
        if ($this->filterStatus !== 'all') {
            if ($this->filterStatus === 'open') {
                $query->whereIn('status', ['open', 'in_progress', 'waiting_customer']);
            } else {
                $query->where('status', $this->filterStatus);
            }
        }

        // Filtro de prioridade
        if ($this->filterPriority !== 'all') {
            $query->where('priority', $this->filterPriority);
        }

        // Busca por número ou assunto
        if ($this->search) {
            $query->where(function($q) {
                $q->where('ticket_number', 'like', '%' . $this->search . '%')
                  ->orWhere('subject', 'like', '%' . $this->search . '%');
            });
        }

        return $query->orderBy('created_at', 'desc')
            ->paginate(15);
    }

    /**
     * Contador por status
     */
    #[Computed]
    public function statusCounts()
    {
        $baseQuery = Ticket::where('customer_id', $this->customer->id);

        return [
            'all' => (clone $baseQuery)->count(),
            'open' => (clone $baseQuery)->whereIn('status', ['open', 'in_progress', 'waiting_customer'])->count(),
            'resolved' => (clone $baseQuery)->where('status', 'resolved')->count(),
            'closed' => (clone $baseQuery)->where('status', 'closed')->count(),
        ];
    }

    /**
     * Ver detalhes do ticket
     */
    public function viewTicket($ticketId)
    {
        return $this->redirect(route('customer.tickets.show', $ticketId), navigate: true);
    }

    /**
     * Atualizar busca
     */
    public function updatedSearch()
    {
        $this->resetPage();
    }
    public function render()
    {
        return view('livewire.customer.tickets.index',[
            'tickets' => $this->tickets,
            'statusCounts' => $this->statusCounts,
        ]);
    }
}
