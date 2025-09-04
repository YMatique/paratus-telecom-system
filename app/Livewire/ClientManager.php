<?php

namespace App\Livewire;

use App\Livewire\Concerns\WithToast;
use App\Models\Address;
use App\Models\Customer;
use App\Models\Plan;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('livewire.layouts.app')]
#[Title('Gestão de Clientes')]
class ClientManager extends Component
{
    use WithToast;
    use WithPagination;

     // Navegação e Estado
    public $activeTab = 'list'; // list, create, edit, view, addresses
    public $selectedCustomer = null;
    public $selectedAddress = null;

    // Filtros
    public $search = '';
    public $filterType = 'all'; // all, individual, company
    public $filterStatus = 'all'; // all, active, suspended, inactive
    public $filterDocument = 'all'; // all, bi, nuit, passport
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    // Formulário Cliente
    #[Validate('required|in:individual,company')]
    public $type = 'individual';

    #[Validate('required|string|max:255')]
    public $name = '';

    #[Validate('required|string|max:50|unique:customers,document')]
    public $document = '';

    #[Validate('required|in:bi,nuit,passport')]
    public $document_type = 'bi';

    #[Validate('nullable|email|max:255')]
    public $email = '';

    #[Validate('nullable|string|max:20')]
    public $phone = '';

    #[Validate('nullable|string|max:20')]
    public $whatsapp = '';

    #[Validate('nullable|string|max:255')]
    public $company_name = '';

    #[Validate('required|in:active,suspended,inactive')]
    public $status = 'active';

    #[Validate('nullable|string|max:1000')]
    public $notes = '';

    // Formulário Endereço
    public $showAddressModal = false;
    public $editingAddressId = null;

    #[Validate('required|in:installation,billing,correspondence')]
    public $address_type = 'installation';

    #[Validate('required|string|max:255')]
    public $street = '';

    #[Validate('nullable|string|max:50')]
    public $number = '';

    #[Validate('required|string|max:100')]
    public $neighborhood = '';

    #[Validate('required|string|max:100')]
    public $district = '';

    #[Validate('required|string|max:100')]
    public $city = '';

    #[Validate('required|string|max:100')]
    public $province = '';

    #[Validate('nullable|string|max:8')]
    public $postal_code = '';

    #[Validate('nullable|string|max:255')]
    public $reference = '';

    #[Validate('nullable|numeric|between:-90,90')]
    public $latitude = '';

    #[Validate('nullable|numeric|between:-180,180')]
    public $longitude = '';

    #[Validate('boolean')]
    public $is_primary = false;

    // Bulk Actions
    public $selectedCustomers = [];

    protected $listeners = [
        'customerDeleted' => '$refresh',
        'addressDeleted' => '$refresh',
    ];

    public function mount()
    {
        $this->resetPage();
    }

    // Watchers para filtros
    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedFilterType()
    {
        $this->resetPage();
    }

    public function updatedFilterStatus()
    {
        $this->resetPage();
    }

    public function updatedFilterDocument()
    {
        $this->resetPage();
    }

    // Navegação
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

    // =====================================
    // CRUD CLIENTES
    // =====================================

    public function createCustomer()
    {
        $this->resetCustomerForm();
        $this->activeTab = 'create';
    }

    public function editCustomer($customerId)
    {
        $customer = Customer::findOrFail($customerId);
        $this->selectedCustomer = $customer;
        $this->fillCustomerForm($customer);
        $this->activeTab = 'edit';
    }

    public function viewCustomer($customerId)
    {
        $this->selectedCustomer = Customer::with(['addresses', 'subscriptions', 'invoices', 'tickets'])->findOrFail($customerId);
        $this->activeTab = 'view';
    }

    public function saveCustomer()
    {
        // Atualizar validação para edição
        if ($this->selectedCustomer) {
            $this->validate([
                'document' => 'required|string|max:50|unique:customers,document,' . $this->selectedCustomer->id,
            ]);
        }
        
        $this->validate();

        $data = [
            'type' => $this->type,
            'name' => $this->name,
            'document' => $this->document,
            'document_type' => $this->document_type,
            'email' => $this->email,
            'phone' => $this->phone,
            'whatsapp' => $this->whatsapp,
            'company_name' => $this->company_name,
            'status' => $this->status,
            'notes' => $this->notes,
        ];

        if ($this->selectedCustomer) {
            // Update
            $this->selectedCustomer->update($data);
            $this->toastSuccess('Sucesso','Cliente atualizado com sucesso!');
        } else {
            // Create
            Customer::create($data);
            $this->toastSuccess('Sucesso','Cliente criado com sucesso!');
        }

        $this->resetCustomerForm();
        $this->activeTab = 'list';
    }

    public function deleteCustomer($customerId)
    {
        $customer = Customer::findOrFail($customerId);
        
        // Verificar se tem subscrições ativas
        if ($customer->subscriptions()->where('status', 'active')->exists()) {
            // session()->flash('error', 'Não é possível excluir cliente com subscrições ativas.');
            $this->toastError('Erro','Não é possível excluir cliente com subscrições ativas.');
            return;
        }

        $customer->delete();
        // session()->flash('message', 'Cliente excluído com sucesso!');
        $this->toastSuccess('Sucesso','Cliente excluído com sucesso!');
    }

    // =====================================
    // CRUD ENDEREÇOS
    // =====================================

    public function manageAddresses($customerId)
    {
        $this->selectedCustomer = Customer::with('addresses')->findOrFail($customerId);
        $this->activeTab = 'addresses';
    }

    public function createAddress()
    {
        $this->resetAddressForm();
        $this->showAddressModal = true;
    }

    public function editAddress($addressId)
    {
        $address = Address::findOrFail($addressId);
        $this->selectedAddress = $address;
        $this->fillAddressForm($address);
        $this->editingAddressId = $addressId;
        $this->showAddressModal = true;
    }

    public function saveAddress()
    {
        $this->validate([
            'address_type' => 'required|in:installation,billing,correspondence',
            'street' => 'required|string|max:255',
            'number' => 'nullable|string|max:50',
            'neighborhood' => 'required|string|max:100',
            'district' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'province' => 'required|string|max:100',
            'postal_code' => 'nullable|string|max:8',
            'reference' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'is_primary' => 'boolean',
        ]);

        $data = [
            'customer_id' => $this->selectedCustomer->id,
            'type' => $this->address_type,
            'street' => $this->street,
            'number' => $this->number,
            'neighborhood' => $this->neighborhood,
            'district' => $this->district,
            'city' => $this->city,
            'province' => $this->province,
            'postal_code' => $this->postal_code,
            'reference' => $this->reference,
            'latitude' => $this->latitude ?: null,
            'longitude' => $this->longitude ?: null,
            'is_primary' => $this->is_primary,
        ];

        if ($this->editingAddressId) {
            // Update
            Address::find($this->editingAddressId)->update($data);
            session()->flash('message', 'Endereço atualizado com sucesso!');
        } else {
            // Create
            Address::create($data);
            session()->flash('message', 'Endereço criado com sucesso!');
        }

        // Se for primário, remover primário de outros
        if ($this->is_primary) {
            Address::where('customer_id', $this->selectedCustomer->id)
                  ->where('id', '!=', $this->editingAddressId ?? 0)
                  ->update(['is_primary' => false]);
        }

        $this->resetAddressForm();
        $this->showAddressModal = false;
        $this->selectedCustomer->refresh();
    }

    public function deleteAddress($addressId)
    {
        Address::findOrFail($addressId)->delete();
        session()->flash('message', 'Endereço excluído com sucesso!');
        $this->selectedCustomer->refresh();
    }

    // =====================================
    // BULK ACTIONS
    // =====================================

    public function selectAllCustomers()
    {
        $this->selectedCustomers = $this->getCustomersQuery()->pluck('id')->toArray();
    }

    public function bulkActivate()
    {
        Customer::whereIn('id', $this->selectedCustomers)->update(['status' => 'active']);
        $this->selectedCustomers = [];
        session()->flash('message', 'Clientes ativados com sucesso!');
    }

    public function bulkSuspend()
    {
        Customer::whereIn('id', $this->selectedCustomers)->update(['status' => 'suspended']);
        $this->selectedCustomers = [];
        session()->flash('message', 'Clientes suspensos com sucesso!');
    }

    public function bulkDeactivate()
    {
        Customer::whereIn('id', $this->selectedCustomers)->update(['status' => 'inactive']);
        $this->selectedCustomers = [];
        session()->flash('message', 'Clientes desativados com sucesso!');
    }

    // =====================================
    // HELPERS
    // =====================================

    private function resetCustomerForm()
    {
        $this->reset([
            'type', 'name', 'document', 'document_type', 'email', 'phone',
            'whatsapp', 'company_name', 'status', 'notes'
        ]);
        $this->selectedCustomer = null;
        $this->type = 'individual';
        $this->document_type = 'bi';
        $this->status = 'active';
        $this->resetErrorBag();
    }

    private function fillCustomerForm(Customer $customer)
    {
        $this->type = $customer->type;
        $this->name = $customer->name;
        $this->document = $customer->document;
        $this->document_type = $customer->document_type;
        $this->email = $customer->email;
        $this->phone = $customer->phone;
        $this->whatsapp = $customer->whatsapp;
        $this->company_name = $customer->company_name;
        $this->status = $customer->status;
        $this->notes = $customer->notes;
    }

    private function resetAddressForm()
    {
        $this->reset([
            'address_type', 'street', 'number', 'neighborhood', 'district',
            'city', 'province', 'postal_code', 'reference', 'latitude', 
            'longitude', 'is_primary'
        ]);
        $this->selectedAddress = null;
        $this->editingAddressId = null;
        $this->address_type = 'installation';
        $this->is_primary = false;
        $this->resetErrorBag();
    }

    private function fillAddressForm(Address $address)
    {
        $this->address_type = $address->type;
        $this->street = $address->street;
        $this->number = $address->number;
        $this->neighborhood = $address->neighborhood;
        $this->district = $address->district;
        $this->city = $address->city;
        $this->province = $address->province;
        $this->postal_code = $address->postal_code;
        $this->reference = $address->reference;
        $this->latitude = $address->latitude;
        $this->longitude = $address->longitude;
        $this->is_primary = $address->is_primary;
    }

    // Query Builder
    private function getCustomersQuery()
    {
        $query = Customer::query();

        // Search
        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%')
                  ->orWhere('document', 'like', '%' . $this->search . '%')
                  ->orWhere('phone', 'like', '%' . $this->search . '%')
                  ->orWhere('company_name', 'like', '%' . $this->search . '%');
            });
        }

        // Filters
        if ($this->filterType !== 'all') {
            $query->where('type', $this->filterType);
        }

        if ($this->filterStatus !== 'all') {
            $query->where('status', $this->filterStatus);
        }

        if ($this->filterDocument !== 'all') {
            $query->where('document_type', $this->filterDocument);
        }

        // Sorting
        $query->orderBy($this->sortField, $this->sortDirection);

        return $query;
    }

    public function render()
    {
       $customers = $this->getCustomersQuery()->paginate(15);

        // Stats
        $stats = [
            'total' => Customer::count(),
            'active' => Customer::where('status', 'active')->count(),
            'individual' => Customer::where('type', 'individual')->count(),
            'company' => Customer::where('type', 'company')->count(),
        ];
        return view('livewire.client-manager',[
            'customers' => $customers,
            'stats' => $stats,
        ]);
    }
    public function boot()
    {
        // Disponibilizar variáveis para o layout via ViewData
        view()->share([
            'pageTitle' => 'Gestão de Clientes',
            'pageDescription' => 'Gerenciar clientes',
            'breadcrumbs' => [
                ['label' => 'Clientes', 'url' => '#'],
                // ['label' => 'Planos', 'url' => '']
            ]
        ]);
    }
}
