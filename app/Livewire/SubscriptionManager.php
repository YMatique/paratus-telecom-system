<?php

namespace App\Livewire;

use App\Livewire\Concerns\WithToast;
use App\Models\Address;
use App\Models\Customer;
use App\Models\Plan;
use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

    #[Layout('livewire.layouts.app')]
    #[Title('Gestão de Subscrições')]
class SubscriptionManager extends Component
{

    use WithToast, WithPagination;

    // Tabs/Estados da interface
    public $activeTab = 'list'; // list, create, view, edit
    public $selectedSubscription = null;

    // Filtros da listagem
    public $search = '';
    public $filterStatus = 'all'; // all, active, suspended, cancelled, pending_installation
    public $filterPlan = 'all';
    public $filterDueDate = 'all'; // all, due_soon, overdue
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    // Wizard de Criação (Step by Step)
    public $wizardStep = 1; // 1: Cliente, 2: Plano, 3: Configuração
    
    // Dados para Criação/Edição
    #[Validate('required|exists:customers,id')]
    public $customer_id = '';
    
    #[Validate('required|exists:plans,id')]
    public $plan_id = '';
    
    #[Validate('required|exists:addresses,id')]
    public $installation_address_id = '';
    
    #[Validate('required|date')]
    public $start_date = '';
    
    #[Validate('nullable|date|after:start_date')]
    public $end_date = '';
    
    #[Validate('required|in:active,suspended,cancelled,pending_installation')]
    public $status = 'pending_installation';
    
    #[Validate('required|numeric|min:0')]
    public $monthly_price = '';
    
    #[Validate('required|numeric|min:0')]
    public $installation_fee = '';
    
    #[Validate('required|boolean')]
    public $auto_renew = true;
    
    #[Validate('required|integer|min:1|max:28')]
    public $billing_day = 1;
    
    #[Validate('nullable|string|max:1000')]
    public $notes = '';

    // Dados auxiliares para selects
    public $customers = [];
    public $plans = [];
    public $addresses = [];
    public $selectedCustomer = null;
    public $selectedPlan = null;

    // Ações em massa
    public $selectedSubscriptions = [];
    public $bulkAction = '';

    // Modais
    public $showActionModal = false;
    public $actionType = ''; // suspend, reactivate, cancel, change_plan
    public $actionReason = '';
    public $actionDate = '';

    protected $listeners = [
        'subscriptionUpdated' => '$refresh',
        'subscriptionDeleted' => '$refresh',
    ];

    public function mount()
    {
        $this->start_date = now()->toDateString();
        $this->loadSelectData();
    }

    public function loadSelectData()
    {
        $this->customers = Customer::active()
            ->orderBy('name')
            ->get(['id', 'name', 'document', 'type']);
            
        $this->plans = Plan::active()
            ->orderBy('name')
            ->get(['id', 'name', 'price', 'download_speed', 'upload_speed']);
    }

    // === TAB NAVIGATION ===
    public function goToList()
    {
        $this->activeTab = 'list';
        $this->resetForm();
    }

    public function createSubscription()
    {
        $this->activeTab = 'create';
        $this->wizardStep = 1;
        $this->resetForm();
        $this->loadSelectData();
    }

    public function viewSubscription($subscriptionId)
    {
        $this->selectedSubscription = Subscription::with([
            'customer', 'plan', 'installationAddress', 
            'invoices' => function($q) { $q->latest()->take(5); },
            'tickets' => function($q) { $q->latest()->take(3); }
        ])->findOrFail($subscriptionId);
        
        $this->activeTab = 'view';
    }

    public function editSubscription($subscriptionId)
    {
        $this->selectedSubscription = Subscription::findOrFail($subscriptionId);
        $this->fillFormFromSubscription($this->selectedSubscription);
        $this->activeTab = 'edit';
        $this->loadAddressesForCustomer($this->customer_id);
    }

    // === WIZARD STEPS ===
    public function nextStep()
    {
        if ($this->wizardStep == 1) {
            $this->validateOnly('customer_id');
            $this->loadAddressesForCustomer($this->customer_id);
            $this->selectedCustomer = Customer::find($this->customer_id);
        } elseif ($this->wizardStep == 2) {
            $this->validateOnly('plan_id', 'installation_address_id');
            $this->selectedPlan = Plan::find($this->plan_id);
            $this->monthly_price = $this->selectedPlan->price;
        }
        
        $this->wizardStep++;
    }

    public function previousStep()
    {
        $this->wizardStep--;
    }

    public function loadAddressesForCustomer($customerId)
    {
        $this->addresses = Address::where('customer_id', $customerId)
            ->orderBy('type')
            ->get();
    }

    // === CRUD OPERATIONS ===
    public function saveSubscription()
    {
        $this->validate();

        try {
            DB::transaction(function () {
                $data = [
                    'customer_id' => $this->customer_id,
                    'plan_id' => $this->plan_id,
                    'installation_address_id' => $this->installation_address_id,
                    'start_date' => $this->start_date,
                    'end_date' => $this->end_date,
                    'status' => $this->status,
                    'monthly_price' => $this->monthly_price,
                    'installation_fee' => $this->installation_fee,
                    'auto_renew' => $this->auto_renew,
                    'billing_day' => $this->billing_day,
                    'notes' => $this->notes,
                ];

                // Calcular próxima data de faturamento
                if ($this->status === 'active') {
                    $startDate = Carbon::parse($this->start_date);
                    $nextBillingDate = $startDate->copy()->addMonth()->day($this->billing_day);
                    $data['next_invoice_date'] = $nextBillingDate->toDateString();
                }

                if ($this->activeTab === 'create') {
                    Subscription::create($data);
                    $this->toastSuccess('Subscrição criada com sucesso!');
                } else {
                    $this->selectedSubscription->update($data);
                    $this->toastSuccess('Subscrição atualizada com sucesso!');
                }
            });

            $this->goToList();
        } catch (\Exception $e) {
            $this->toastError('Erro ao salvar subscrição: ' . $e->getMessage());
        }
    }

    // === SUBSCRIPTION ACTIONS ===
    public function suspendSubscription($subscriptionId, $reason = null)
    {
        try {
            $subscription = Subscription::findOrFail($subscriptionId);
            
            if (!$subscription->canBeSuspended()) {
                $this->toastError('Esta subscrição não pode ser suspensa');
                return;
            }

            $subscription->update([
                'status' => 'suspended',
                'notes' => $subscription->notes . "\n" . 'Suspensa em ' . now()->format('d/m/Y H:i') . 
                          ($reason ? " - Motivo: $reason" : '')
            ]);

            $this->toastSuccess('Subscrição suspensa com sucesso!');
        } catch (\Exception $e) {
            $this->toastError('Erro ao suspender subscrição');
        }
    }

    public function reactivateSubscription($subscriptionId)
    {
        try {
            $subscription = Subscription::findOrFail($subscriptionId);
            
            // Recalcular próxima data de faturamento
            $nextBillingDate = now()->day($subscription->billing_day);
            if ($nextBillingDate->isPast()) {
                $nextBillingDate->addMonth();
            }

            $subscription->update([
                'status' => 'active',
                'next_invoice_date' => $nextBillingDate->toDateString(),
                'notes' => $subscription->notes . "\n" . 'Reativada em ' . now()->format('d/m/Y H:i')
            ]);

            $this->toastSuccess('Subscrição reativada com sucesso!');
        } catch (\Exception $e) {
            $this->toastError('Erro ao reativar subscrição');
        }
    }

    public function cancelSubscription($subscriptionId, $reason = null)
    {
        try {
            $subscription = Subscription::findOrFail($subscriptionId);
            
            if (!$subscription->canBeCancelled()) {
                $this->toastError('Esta subscrição não pode ser cancelada');
                return;
            }

            $subscription->update([
                'status' => 'cancelled',
                'end_date' => now()->toDateString(),
                'notes' => $subscription->notes . "\n" . 'Cancelada em ' . now()->format('d/m/Y H:i') . 
                          ($reason ? " - Motivo: $reason" : '')
            ]);

            $this->toastSuccess('Subscrição cancelada com sucesso!');
        } catch (\Exception $e) {
            $this->toastError('Erro ao cancelar subscrição');
        }
    }

    // === BULK ACTIONS ===
    public function executeBulkAction()
    {
        if (empty($this->selectedSubscriptions) || empty($this->bulkAction)) {
            $this->toastWarning('Selecione subscrições e uma ação');
            return;
        }

        try {
            $count = count($this->selectedSubscriptions);
            
            switch ($this->bulkAction) {
                case 'suspend':
                    Subscription::whereIn('id', $this->selectedSubscriptions)
                        ->where('status', 'active')
                        ->update(['status' => 'suspended']);
                    $this->toastSuccess("$count subscrições suspensas");
                    break;
                    
                case 'reactivate':
                    Subscription::whereIn('id', $this->selectedSubscriptions)
                        ->where('status', 'suspended')
                        ->update(['status' => 'active']);
                    $this->toastSuccess("$count subscrições reativadas");
                    break;
            }

            $this->selectedSubscriptions = [];
            $this->bulkAction = '';
        } catch (\Exception $e) {
            $this->toastError('Erro na ação em massa');
        }
    }

    // === HELPERS ===
    private function resetForm()
    {
        $this->reset([
            'customer_id', 'plan_id', 'installation_address_id', 'start_date',
            'end_date', 'status', 'monthly_price', 'installation_fee',
            'auto_renew', 'billing_day', 'notes', 'wizardStep'
        ]);
        
        $this->selectedSubscription = null;
        $this->selectedCustomer = null;
        $this->selectedPlan = null;
        $this->start_date = now()->toDateString();
        $this->status = 'pending_installation';
        $this->auto_renew = true;
        $this->billing_day = 1;
        $this->wizardStep = 1;
    }

    private function fillFormFromSubscription(Subscription $subscription)
    {
        $this->customer_id = $subscription->customer_id;
        $this->plan_id = $subscription->plan_id;
        $this->installation_address_id = $subscription->installation_address_id;
        $this->start_date = $subscription->start_date->toDateString();
        $this->end_date = $subscription->end_date?->toDateString();
        $this->status = $subscription->status;
        $this->monthly_price = $subscription->monthly_price;
        $this->installation_fee = $subscription->installation_fee;
        $this->auto_renew = $subscription->auto_renew;
        $this->billing_day = $subscription->billing_day;
        $this->notes = $subscription->notes;
    }

    // === QUERY BUILDER ===
    private function getSubscriptionsQuery()
    {
        $query = Subscription::with(['customer', 'plan', 'installationAddress']);

        // Search
        if ($this->search) {
            $query->whereHas('customer', function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('document', 'like', '%' . $this->search . '%');
            })->orWhereHas('plan', function($q) {
                $q->where('name', 'like', '%' . $this->search . '%');
            });
        }

        // Filters
        if ($this->filterStatus !== 'all') {
            $query->where('status', $this->filterStatus);
        }

        if ($this->filterPlan !== 'all') {
            $query->where('plan_id', $this->filterPlan);
        }

        if ($this->filterDueDate === 'due_soon') {
            $query->where('next_invoice_date', '<=', now()->addDays(7)->toDateString())
                  ->where('status', 'active');
        } elseif ($this->filterDueDate === 'overdue') {
            $query->where('next_invoice_date', '<', now()->toDateString())
                  ->where('status', 'active');
        }

        // Sorting
        $query->orderBy($this->sortField, $this->sortDirection);

        return $query;
    }

    public function render()
    {
        $subscriptions = $this->getSubscriptionsQuery()->paginate(15);

        // Stats para cards
        $stats = [
            'total_active' => Subscription::where('status', 'active')->count(),
            'total_suspended' => Subscription::where('status', 'suspended')->count(),
            'pending_installation' => Subscription::where('status', 'pending_installation')->count(),
            'mrr' => Subscription::where('status', 'active')->sum('monthly_price'),
            'due_soon' => Subscription::where('status', 'active')
                ->where('next_invoice_date', '<=', now()->addDays(7)->toDateString())
                ->count(),
        ];
        return view('livewire.subscription-manager', [
            'subscriptions' => $subscriptions,
            'stats' => $stats,
        ]);
    }
      public function boot()
    {
        view()->share([
            'pageTitle' => 'Gestão de Subscrições',
            'pageDescription' => 'Gerenciar contratos e subscrições ativas',
            'breadcrumbs' => [
                ['label' => 'Operações', 'url' => '#'],
                ['label' => 'Subscrições', 'url' => '']
            ]
        ]);
    }
}
