<?php

namespace App\Livewire;

use App\Livewire\Concerns\WithToast;
use App\Models\Customer;
use App\Models\Subscription;
use App\Models\Ticket;
use App\Models\TicketResponse;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('livewire.layouts.app')]
#[Title('Sistema de Tickets')]
class TicketManager extends Component
{
    use WithToast, WithPagination;

    protected $queryString = [
        'search' => ['except' => ''],
        'filterStatus' => ['except' => 'all'],
        'filterPriority' => ['except' => 'all'],
        'filterCategory' => ['except' => 'all'],
        'filterAssigned' => ['except' => 'all'],
    ];

    // Navegação e Estados
    public $activeTab = 'list'; // list, create, view, stats
    public $selectedTicket = null;

    // Filtros da listagem
    public $search = '';
    public $filterStatus = 'all';
    public $filterPriority = 'all';
    public $filterCategory = 'all';
    public $filterAssigned = 'all';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    // Formulário de Criação/Edição
    #[Validate('required|exists:customers,id')]
    public $customer_id = '';

    #[Validate('nullable|exists:subscriptions,id')]
    public $subscription_id = '';

    #[Validate('nullable|exists:users,id')]
    public $assigned_to = '';

    #[Validate('required|string|max:255')]
    public $subject = '';

    #[Validate('required|string')]
    public $description = '';

    #[Validate('required|in:low,medium,high,urgent')]
    public $priority = 'medium';

    #[Validate('required|in:technical,billing,installation,complaint,request')]
    public $category = 'technical';

    #[Validate('required|in:open,in_progress,waiting_customer,resolved,closed')]
    public $status = 'open';

    // Formulário de Resposta
    #[Validate('required|string')]
    public $response_text = '';

    #[Validate('boolean')]
    public $is_internal = false;

    #[Validate('boolean')]
    public $is_solution = false;

    // Dados auxiliares
    public $customers = [];
    public $subscriptions = [];
    public $users = [];
    public $selectedCustomer = null;

    // Ações em massa
    public $selectedTickets = [];
    public $bulkAction = '';

    // Modais
    public $showResponseModal = false;
    public $showAssignModal = false;
    public $showStatusModal = false;

    protected $listeners = [
        'ticketUpdated' => '$refresh',
        'responseAdded' => '$refresh',
    ];

    public function mount()
    {
        $this->loadSelectData();
    }

    public function loadSelectData()
    {
        $this->customers = Customer::active()
            ->orderBy('name')
            ->get(['id', 'name', 'document']);

        $this->users = User::orderBy('name')
            ->get(['id', 'name', 'email']);
    }

    // === NAVEGAÇÃO ===
    public function goToList()
    {
        $this->activeTab = 'list';
        $this->resetForm();
    }

    public function createTicket()
    {
        $this->activeTab = 'create';
        $this->resetForm();
        $this->loadSelectData();
    }

    public function viewTicket($ticketId)
    {
        $this->selectedTicket = Ticket::with([
            'customer',
            'subscription.plan',
            'assignedTo',
            'responses' => function ($q) {
                $q->with('user')->latest();
            }
        ])->findOrFail($ticketId);

        $this->activeTab = 'view';
    }

    public function editTicket($ticketId)
    {
        $this->selectedTicket = Ticket::findOrFail($ticketId);
        $this->fillFormFromTicket($this->selectedTicket);
        $this->activeTab = 'create'; // Reusa o formulário de criação
    }

    // === FORMULÁRIO ===
    public function saveTicket()
    {
        $this->validate();

        try {
            if ($this->selectedTicket) {
                // Edição
                $this->selectedTicket->update([
                    'customer_id' => $this->customer_id,
                    'subscription_id' => $this->subscription_id ?: null,
                    'assigned_to' => $this->assigned_to ?: null,
                    'subject' => $this->subject,
                    'description' => $this->description,
                    'priority' => $this->priority,
                    'category' => $this->category,
                    'status' => $this->status,
                ]);

                $this->toastSuccess('Ticket atualizado com sucesso!');
            } else {
                // Criação
                $ticket = Ticket::create([
                    'customer_id' => $this->customer_id,
                    'subscription_id' => $this->subscription_id ?: null,
                    'assigned_to' => $this->assigned_to ?: null,
                    'subject' => $this->subject,
                    'description' => $this->description,
                    'priority' => $this->priority,
                    'category' => $this->category,
                    'status' => $this->status,
                ]);

                $this->toastSuccess("Ticket {$ticket->ticket_number} criado com sucesso!");
                $this->selectedTicket = $ticket;
            }

            $this->activeTab = 'view';
        } catch (\Exception $e) {
            $this->toastError('Erro ao salvar ticket', $e->getMessage());
        }
    }

    // === AÇÕES DO TICKET ===
    public function assignTicket($ticketId, $userId)
    {
        try {
            $ticket = Ticket::findOrFail($ticketId);
            $ticket->update(['assigned_to' => $userId]);

            $this->toastSuccess('Ticket atribuído com sucesso!');
            $this->dispatch('ticketUpdated');
        } catch (\Exception $e) {
            $this->toastError('Erro ao atribuir ticket');
        }
    }

    public function changeStatus($ticketId, $newStatus)
    {
        try {
            $ticket = Ticket::findOrFail($ticketId);

            $oldStatus = $ticket->status;
            $ticket->status = $newStatus;

            // Atualizar timestamps conforme o status
            if ($newStatus === 'resolved' && $oldStatus !== 'resolved') {
                $ticket->resolved_at = now();
            } elseif ($newStatus === 'closed' && $oldStatus !== 'closed') {
                $ticket->closed_at = now();
                $ticket->resolved_at = $ticket->resolved_at ?? now();
            } elseif (in_array($newStatus, ['open', 'in_progress', 'waiting_customer'])) {
                $ticket->resolved_at = null;
                $ticket->closed_at = null;
            }

            $ticket->save();

            $this->toastSuccess('Status do ticket atualizado!');
            $this->dispatch('ticketUpdated');
        } catch (\Exception $e) {
            $this->toastError('Erro ao alterar status');
        }
    }

    public function addResponse()
    {
        $this->validate([
            'response_text' => 'required|string',
        ]);

        try {
            TicketResponse::create([
                'ticket_id' => $this->selectedTicket->id,
                'user_id' => Auth::id(),
                'response' => $this->response_text,
                'is_internal' => $this->is_internal,
                'is_solution' => $this->is_solution,
            ]);

            // Se é uma solução, marcar ticket como resolvido
            if ($this->is_solution) {
                $this->selectedTicket->markAsResolved(Auth::id());
            }

            $this->reset(['response_text', 'is_internal', 'is_solution']);
            $this->showResponseModal = false;

            $this->toastSuccess('Resposta adicionada com sucesso!');
            $this->dispatch('responseAdded');

            // Recarregar ticket para mostrar nova resposta
            $this->viewTicket($this->selectedTicket->id);
        } catch (\Exception $e) {
            $this->toastError('Erro ao adicionar resposta');
        }
    }

    // === CUSTOMER SELECTION ===
    public function updatedCustomerId($customerId)
    {
        if ($customerId) {
            $this->selectedCustomer = Customer::find($customerId);

            // Carregar subscrições do cliente
            $this->subscriptions = Subscription::where('customer_id', $customerId)
                ->with('plan')
                ->get();
        } else {
            $this->subscriptions = [];
            $this->selectedCustomer = null;
            $this->subscription_id = '';
        }
    }

    // === BULK ACTIONS ===
    public function executeBulkAction()
    {
        if (empty($this->selectedTickets) || empty($this->bulkAction)) {
            $this->toastWarning('Selecione tickets e uma ação');
            return;
        }

        try {
            $count = count($this->selectedTickets);

            switch ($this->bulkAction) {
                case 'assign_me':
                    Ticket::whereIn('id', $this->selectedTickets)
                        ->update(['assigned_to' => Auth::id()]);
                    $this->toastSuccess("$count tickets atribuídos para você");
                    break;

                case 'mark_resolved':
                    Ticket::whereIn('id', $this->selectedTickets)
                        ->update([
                            'status' => 'resolved',
                            'resolved_at' => now()
                        ]);
                    $this->toastSuccess("$count tickets marcados como resolvidos");
                    break;

                case 'mark_closed':
                    Ticket::whereIn('id', $this->selectedTickets)
                        ->update([
                            'status' => 'closed',
                            'closed_at' => now(),
                            'resolved_at' => now()
                        ]);
                    $this->toastSuccess("$count tickets fechados");
                    break;
            }

            $this->selectedTickets = [];
            $this->bulkAction = '';
        } catch (\Exception $e) {
            $this->toastError('Erro na ação em massa');
        }
    }

    // === HELPERS ===
    private function resetForm()
    {
        $this->reset([
            'customer_id',
            'subscription_id',
            'assigned_to',
            'subject',
            'description',
            'priority',
            'category',
            'status',
            'response_text',
            'is_internal',
            'is_solution'
        ]);

        $this->selectedTicket = null;
        $this->selectedCustomer = null;
        $this->subscriptions = [];
        $this->priority = 'medium';
        $this->category = 'technical';
        $this->status = 'open';
    }

    private function fillFormFromTicket(Ticket $ticket)
    {
        $this->customer_id = $ticket->customer_id;
        $this->subscription_id = $ticket->subscription_id;
        $this->assigned_to = $ticket->assigned_to;
        $this->subject = $ticket->subject;
        $this->description = $ticket->description;
        $this->priority = $ticket->priority;
        $this->category = $ticket->category;
        $this->status = $ticket->status;

        // Carregar subscrições do cliente
        $this->updatedCustomerId($this->customer_id);
    }

    // === QUERY BUILDER ===
    private function getTicketsQuery()
    {
        $query = Ticket::with(['customer', 'subscription.plan', 'assignedTo']);

        // Search
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('ticket_number', 'like', '%' . $this->search . '%')
                    ->orWhere('subject', 'like', '%' . $this->search . '%')
                    ->orWhereHas('customer', function ($customerQuery) {
                        $customerQuery->where('name', 'like', '%' . $this->search . '%');
                    });
            });
        }

        // Filters
        if ($this->filterStatus !== 'all') {
            if ($this->filterStatus === 'open') {
                $query->open();
            } elseif ($this->filterStatus === 'closed') {
                $query->closed();
            } else {
                $query->where('status', $this->filterStatus);
            }
        }

        if ($this->filterPriority !== 'all') {
            $query->where('priority', $this->filterPriority);
        }

        if ($this->filterCategory !== 'all') {
            $query->where('category', $this->filterCategory);
        }

        if ($this->filterAssigned !== 'all') {
            if ($this->filterAssigned === 'unassigned') {
                $query->unassigned();
            } elseif ($this->filterAssigned === 'me') {
                $query->assignedTo(Auth::id());
            } else {
                $query->assignedTo($this->filterAssigned);
            }
        }

        // Sorting
        $query->orderBy($this->sortField, $this->sortDirection);

        return $query;
    }

    public function render()
    {
        $tickets = $this->getTicketsQuery()->paginate(15);

        // Stats para dashboard
        $stats = [
            'total_open' => Ticket::open()->count(),
            'total_urgent' => Ticket::where('priority', 'urgent')->open()->count(),
            'my_tickets' => Ticket::where('assigned_to', Auth::id())->open()->count(),
            'unassigned' => Ticket::unassigned()->open()->count(),
            'resolved_today' => Ticket::whereDate('resolved_at', today())->count(),
            'avg_response_time' => $this->getAverageResponseTime(),
        ];
        return view('livewire.ticket-manager', [
            'tickets' => $tickets,
            'stats' => $stats,
        ]);
    }
        private function getAverageResponseTime()
    {
        $resolved = Ticket::whereNotNull('resolved_at')
            ->whereDate('resolved_at', '>=', now()->subDays(30))
            ->get();

        if ($resolved->isEmpty()) {
            return 0;
        }

        $totalHours = $resolved->sum(function($ticket) {
            return $ticket->opened_at->diffInHours($ticket->resolved_at);
        });

        return round($totalHours / $resolved->count(), 1);
    }

    public function boot()
    {
        view()->share([
            'pageTitle' => 'Sistema de Tickets',
            'pageDescription' => 'Gerenciar tickets de suporte e atendimento',
            'breadcrumbs' => [
                ['label' => 'Suporte', 'url' => '#'],
                ['label' => 'Tickets', 'url' => '']
            ]
        ]);
    }
}
