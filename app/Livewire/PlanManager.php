<?php

namespace App\Livewire;

use App\Livewire\Concerns\WithToast;
use App\Models\Plan;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('livewire.layouts.app')]
#[Title('Gestão de Planos')]
class PlanManager extends Component
{

    use WithToast;
    use WithPagination;






    public $activeTab = 'list'; // list, create, edit, promotions
    public $showModal = false;
    public $selectedPlan = null;

    // Filtros
    public $search = '';
    public $filterConnectionType = 'all'; // all, fiber, radio, adsl
    public $filterCustomerType = 'all'; // all, individual, company, both
    public $filterStatus = 'all'; // all, active, inactive
    public $sortField = 'sort_order'; // name, price, download_speed, sort_order
    public $sortDirection = 'asc';

    // Formulário
    #[Validate('required|string|max:255')]
    public $name = '';

    #[Validate('nullable|string|max:1000')]
    public $description = '';

    #[Validate('required|integer|min:1|max:10000')]
    public $download_speed = '';

    #[Validate('required|integer|min:1|max:10000')]
    public $upload_speed = '';

    #[Validate('required|numeric|min:0|max:999999.99')]
    public $price = '';

    #[Validate('required|in:monthly,quarterly,annual')]
    public $billing_cycle = 'monthly';

    #[Validate('boolean')]
    public $unlimited_data = true;

    #[Validate('nullable|integer|min:1|max:999999')]
    public $data_limit_gb = null;

    #[Validate('required|in:fiber,radio,adsl')]
    public $connection_type = 'fiber';

    #[Validate('required|in:individual,company,both')]
    public $customer_type = 'both';

    #[Validate('boolean')]
    public $is_active = true;

    #[Validate('integer|min:0')]
    public $sort_order = 0;

    protected $listeners = [
        'planDeleted' => '$refresh',
        'planUpdated' => '$refresh',
    ];

    public function mount()
    {
        $this->resetPage();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedFilterConnectionType()
    {
        $this->resetPage();
    }

    public function updatedFilterCustomerType()
    {
        $this->resetPage();
    }

    public function updatedFilterStatus()
    {
        $this->resetPage();
    }

    // Navegação entre tabs
    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
        $this->resetPage();
    }

    // Ordenação
    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
        $this->resetPage();
    }

    // CRUD Operations
    public function createPlan()
    {
        $this->resetForm();
        $this->activeTab = 'create';
    }

    public function editPlan($planId)
    {
        $plan = Plan::findOrFail($planId);
        $this->selectedPlan = $plan;
        $this->fillForm($plan);
        $this->activeTab = 'edit';
    }

    public function savePlan()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'description' => $this->description,
            'download_speed' => $this->download_speed,
            'upload_speed' => $this->upload_speed,
            'price' => $this->price,
            'billing_cycle' => $this->billing_cycle,
            'unlimited_data' => $this->unlimited_data,
            'data_limit_gb' => $this->unlimited_data ? null : $this->data_limit_gb,
            'connection_type' => $this->connection_type,
            'customer_type' => $this->customer_type,
            'is_active' => $this->is_active,
            'sort_order' => $this->sort_order,
        ];

        if ($this->selectedPlan) {
            // Update
            $this->selectedPlan->update($data);
            // session()->flash('message', 'Plano atualizado com sucesso!');
            $this->toastSuccess('Cliente salvo!', 'Dados atualizados com sucesso.');
        } else {
            // Create
            Plan::create($data);
            session()->flash('message', 'Plano criado com sucesso!');
        }

        $this->resetForm();
        $this->activeTab = 'list';
    }

    public function toggleStatus($planId)
    {
        $plan = Plan::findOrFail($planId);
        $plan->update(['is_active' => !$plan->is_active]);

        $status = $plan->is_active ? 'ativado' : 'desativado';
        session()->flash('message', "Plano {$status} com sucesso!");
    }

    public function duplicatePlan($planId)
    {
        $plan = Plan::findOrFail($planId);
        $newPlan = $plan->replicate();
        $newPlan->name = $plan->name . ' (Cópia)';
        $newPlan->is_active = false;
        $newPlan->save();

        session()->flash('message', 'Plano duplicado com sucesso!');
    }

    public function deletePlan($planId)
    {
        $plan = Plan::findOrFail($planId);

        // Verificar se tem subscrições ativas
        if ($plan->subscriptions()->where('status', 'active')->exists()) {
            session()->flash('error', 'Não é possível excluir um plano com subscrições ativas.');
            return;
        }

        $plan->delete();
        session()->flash('message', 'Plano excluído com sucesso!');
    }

    // Helpers
    private function resetForm()
    {
        $this->reset([
            'name',
            'description',
            'download_speed',
            'upload_speed',
            'price',
            'billing_cycle',
            'unlimited_data',
            'data_limit_gb',
            'connection_type',
            'customer_type',
            'is_active',
            'sort_order'
        ]);
        $this->selectedPlan = null;
        $this->billing_cycle = 'monthly';
        $this->unlimited_data = true;
        $this->connection_type = 'fiber';
        $this->customer_type = 'both';
        $this->is_active = true;
        $this->sort_order = Plan::max('sort_order') + 1 ?? 0;
    }

    private function fillForm(Plan $plan)
    {
        $this->name = $plan->name;
        $this->description = $plan->description;
        $this->download_speed = $plan->download_speed;
        $this->upload_speed = $plan->upload_speed;
        $this->price = $plan->price;
        $this->billing_cycle = $plan->billing_cycle;
        $this->unlimited_data = $plan->unlimited_data;
        $this->data_limit_gb = $plan->data_limit_gb;
        $this->connection_type = $plan->connection_type;
        $this->customer_type = $plan->customer_type;
        $this->is_active = $plan->is_active;
        $this->sort_order = $plan->sort_order;
    }

    // Quick Actions
    public function quickToggleStatus($planId)
    {
        $this->toggleStatus($planId);
    }

    // Bulk Actions
    public $selectedPlans = [];

    public function selectAllPlans()
    {
        $this->selectedPlans = $this->getPlansQuery()->pluck('id')->toArray();
    }

    public function bulkActivate()
    {
        Plan::whereIn('id', $this->selectedPlans)->update(['is_active' => true]);
        $this->selectedPlans = [];
        session()->flash('message', 'Planos ativados com sucesso!');
    }

    public function bulkDeactivate()
    {
        Plan::whereIn('id', $this->selectedPlans)->update(['is_active' => false]);
        $this->selectedPlans = [];
        session()->flash('message', 'Planos desativados com sucesso!');
    }

    // Query Builder
    private function getPlansQuery()
    {
        $query = Plan::query();

        // Search
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        // Filters
        if ($this->filterConnectionType !== 'all') {
            $query->where('connection_type', $this->filterConnectionType);
        }

        if ($this->filterCustomerType !== 'all') {
            if ($this->filterCustomerType === 'both') {
                $query->where('customer_type', 'both');
            } else {
                $query->whereIn('customer_type', [$this->filterCustomerType, 'both']);
            }
        }

        if ($this->filterStatus !== 'all') {
            $query->where('is_active', $this->filterStatus === 'active');
        }

        // Sorting
        $query->orderBy($this->sortField, $this->sortDirection);

        return $query;
    }


    public function render()
    {
        $plans = $this->getPlansQuery()->paginate(10);

        // Stats para dashboard
        $stats = [
            'total' => Plan::count(),
            'active' => Plan::where('is_active', true)->count(),
            'fiber' => Plan::where('connection_type', 'fiber')->count(),
            'radio' => Plan::where('connection_type', 'radio')->count(),
        ];

        return view('livewire.plan-manager', [
            'plans' => $plans,
            'stats' => $stats,
        ]);
    }

    public function boot()
    {
        // Disponibilizar variáveis para o layout via ViewData
        view()->share([
            'pageTitle' => 'Planos de Internet',
            'pageDescription' => 'Gerenciar planos e pacotes de internet',
            'breadcrumbs' => [
                ['label' => 'Serviços', 'url' => '#'],
                ['label' => 'Planos', 'url' => '']
            ]
        ]);
    }
}
