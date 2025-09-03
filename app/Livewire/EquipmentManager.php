<?php

namespace App\Livewire;

use App\Livewire\Concerns\WithToast;
use App\Models\Customer;
use App\Models\Equipment;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('livewire.layouts.app')]
#[Title('Gestão de Equipamentos')]
class EquipmentManager extends Component
{
      use WithToast;
    use WithPagination;

     public $activeTab = 'list'; // list, create, edit, history
    public $selectedEquipment = null;

    // Filtros
    public $search = '';
    public $filterProduct = 'all'; // all, product_id
    public $filterStatus = 'all'; // all, available, installed, maintenance, damaged, lost
    public $filterCustomer = 'all'; // all, customer_id
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    // Formulário Equipamento
    #[Validate('required|exists:products,id')]
    public $product_id = '';

    #[Validate('required|string|max:255|unique:equipment,serial_number')]
    public $serial_number = '';

    #[Validate('nullable|string|max:17')]
    public $mac_address = '';

    #[Validate('required|in:available,installed,maintenance,damaged,lost')]
    public $status = 'available';

    #[Validate('nullable|exists:customers,id')]
    public $customer_id = '';

    #[Validate('nullable|date')]
    public $installation_date = '';

    #[Validate('nullable|date|after_or_equal:installation_date')]
    public $return_date = '';

    #[Validate('nullable|string|max:1000')]
    public $location_notes = '';

    // Modal de Ações Rápidas
    public $showActionModal = false;
    public $actionType = ''; // install, return, maintenance, damage
    public $actionNotes = '';
    public $actionCustomer = '';
    public $actionDate = '';

    // Bulk Actions
    public $selectedEquipments = [];

    // Dados para selects
    public $products = [];
    public $customers = [];

    protected $listeners = [
        'equipmentDeleted' => '$refresh',
        'equipmentUpdated' => '$refresh',
    ];

    // Rules
    protected $rules = [];

    public function mount()
    {
        $this->loadSelectData();
        $this->resetPage();
    }

    private function loadSelectData()
    {
        $this->products = Product::active()->orderBy('name')->get();
        $this->customers = Customer::active()->orderBy('name')->get();
    }

    // Watchers para filtros
    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedFilterProduct()
    {
        $this->resetPage();
    }

    public function updatedFilterStatus()
    {
        $this->resetPage();
    }

    public function updatedFilterCustomer()
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
    // CRUD EQUIPAMENTOS
    // =====================================

    public function createEquipment()
    {
        $this->resetEquipmentForm();
        $this->activeTab = 'create';
    }

    public function editEquipment($equipmentId)
    {
        $equipment = Equipment::with(['product', 'customer'])->findOrFail($equipmentId);
        $this->selectedEquipment = $equipment;
        $this->fillEquipmentForm($equipment);
        $this->activeTab = 'edit';
    }

    public function saveEquipment()
    {
        // Validação dinâmica para unique serial_number
        if ($this->selectedEquipment) {
            $this->rules['serial_number'] = 'required|string|max:255|unique:equipment,serial_number,' . $this->selectedEquipment->id;
        }
        
        $this->validate();

        // Validar MAC address se informado
        if ($this->mac_address) {
            $macRule = 'unique:equipment,mac_address';
            if ($this->selectedEquipment) {
                $macRule .= ',' . $this->selectedEquipment->id;
            }
            $this->validate(['mac_address' => 'nullable|string|max:17|regex:/^([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})$|' . $macRule]);
        }

        $data = [
            'product_id' => $this->product_id,
            'serial_number' => strtoupper(trim($this->serial_number)),
            'mac_address' => $this->mac_address ? strtoupper(str_replace([':', '-'], '', trim($this->mac_address))) : null,
            'status' => $this->status,
            'customer_id' => $this->customer_id ?: null,
            'installation_date' => $this->installation_date ?: null,
            'return_date' => $this->return_date ?: null,
            'location_notes' => $this->location_notes,
        ];

        DB::transaction(function () use ($data) {
            if ($this->selectedEquipment) {
                // Update
                $oldStatus = $this->selectedEquipment->status;
                $this->selectedEquipment->update($data);
                
                // Log mudança de status se necessário
                if ($oldStatus !== $this->status) {
                    $this->logStatusChange($this->selectedEquipment, $oldStatus, $this->status);
                }
                
                session()->flash('message', 'Equipamento atualizado com sucesso!');
            } else {
                // Create
                $equipment = Equipment::create($data);
                session()->flash('message', 'Equipamento cadastrado com sucesso!');
            }
        });

        $this->resetEquipmentForm();
        $this->activeTab = 'list';
    }

    public function deleteEquipment($equipmentId)
    {
        $equipment = Equipment::findOrFail($equipmentId);
        
        // Verificar se está instalado
        if ($equipment->status === 'installed') {
            session()->flash('error', 'Não é possível excluir equipamento instalado. Retorne o equipamento primeiro.');
            return;
        }

        $equipment->delete();
        session()->flash('message', 'Equipamento excluído com sucesso!');
    }

    // =====================================
    // AÇÕES RÁPIDAS
    // =====================================

    public function openActionModal($equipmentId, $action)
    {
        $this->selectedEquipment = Equipment::with(['product', 'customer'])->findOrFail($equipmentId);
        $this->actionType = $action;
        $this->actionNotes = '';
        $this->actionCustomer = '';
        $this->actionDate = now()->format('Y-m-d');
        
        // Pré-definir customer se já instalado
        if ($this->selectedEquipment->customer_id) {
            $this->actionCustomer = $this->selectedEquipment->customer_id;
        }
        
        $this->showActionModal = true;
        $this->resetErrorBag(['actionNotes', 'actionCustomer', 'actionDate']);
    }

    public function executeAction()
    {
        $rules = [
            'actionDate' => 'required|date',
            'actionNotes' => 'nullable|string|max:1000',
        ];

        // Validações específicas por ação
        if (in_array($this->actionType, ['install'])) {
            $rules['actionCustomer'] = 'required|exists:customers,id';
        }

        $this->validate($rules);

        DB::transaction(function () {
            $oldStatus = $this->selectedEquipment->status;
            $updates = [];

            switch ($this->actionType) {
                case 'install':
                    $updates = [
                        'status' => 'installed',
                        'customer_id' => $this->actionCustomer,
                        'installation_date' => $this->actionDate,
                        'return_date' => null,
                        'location_notes' => $this->actionNotes,
                    ];
                    $message = 'Equipamento instalado com sucesso!';
                    break;

                case 'return':
                    $updates = [
                        'status' => 'available',
                        'customer_id' => null,
                        'return_date' => $this->actionDate,
                        'location_notes' => $this->actionNotes,
                    ];
                    $message = 'Equipamento retornado com sucesso!';
                    break;

                case 'maintenance':
                    $updates = [
                        'status' => 'maintenance',
                        'location_notes' => $this->actionNotes,
                    ];
                    $message = 'Equipamento enviado para manutenção!';
                    break;

                case 'damage':
                    $updates = [
                        'status' => 'damaged',
                        'location_notes' => $this->actionNotes,
                    ];
                    $message = 'Equipamento marcado como avariado!';
                    break;
            }

            $this->selectedEquipment->update($updates);
            $this->logStatusChange($this->selectedEquipment, $oldStatus, $updates['status']);
            
            session()->flash('message', $message);
        });

        $this->showActionModal = false;
        $this->selectedEquipment = null;
    }

    private function logStatusChange($equipment, $oldStatus, $newStatus)
    {
        // Aqui poderia implementar log de mudanças
        // EquipmentLog::create([...])
    }

    // =====================================
    // BULK ACTIONS
    // =====================================

    public function selectAllEquipments()
    {
        $this->selectedEquipments = $this->getEquipmentsQuery()->pluck('id')->toArray();
    }

    public function bulkSetMaintenance()
    {
        Equipment::whereIn('id', $this->selectedEquipments)
                ->whereNotIn('status', ['installed'])
                ->update(['status' => 'maintenance']);
        
        $this->selectedEquipments = [];
        session()->flash('message', 'Equipamentos enviados para manutenção!');
    }

    public function bulkSetAvailable()
    {
        Equipment::whereIn('id', $this->selectedEquipments)
                ->whereNotIn('status', ['installed'])
                ->update(['status' => 'available', 'customer_id' => null, 'return_date' => now()]);
        
        $this->selectedEquipments = [];
        session()->flash('message', 'Equipamentos marcados como disponíveis!');
    }

    // =====================================
    // HELPERS
    // =====================================

    private function resetEquipmentForm()
    {
        $this->reset([
            'product_id', 'serial_number', 'mac_address', 'status', 
            'customer_id', 'installation_date', 'return_date', 'location_notes'
        ]);
        $this->selectedEquipment = null;
        $this->status = 'available';
        $this->resetErrorBag();
    }

    private function fillEquipmentForm(Equipment $equipment)
    {
        $this->product_id = $equipment->product_id;
        $this->serial_number = $equipment->serial_number;
        $this->mac_address = $equipment->mac_address;
        $this->status = $equipment->status;
        $this->customer_id = $equipment->customer_id;
        $this->installation_date = $equipment->installation_date?->format('Y-m-d');
        $this->return_date = $equipment->return_date?->format('Y-m-d');
        $this->location_notes = $equipment->location_notes;
    }

    // Query Builder
    private function getEquipmentsQuery()
    {
        $query = Equipment::with(['product', 'customer']);

        // Search
        if ($this->search) {
            $query->where(function($q) {
                $q->where('serial_number', 'like', '%' . $this->search . '%')
                  ->orWhere('mac_address', 'like', '%' . $this->search . '%')
                  ->orWhere('location_notes', 'like', '%' . $this->search . '%')
                  ->orWhereHas('product', function($pq) {
                      $pq->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('brand', 'like', '%' . $this->search . '%')
                        ->orWhere('model', 'like', '%' . $this->search . '%');
                  })
                  ->orWhereHas('customer', function($cq) {
                      $cq->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('document', 'like', '%' . $this->search . '%');
                  });
            });
        }

        // Filters
        if ($this->filterProduct !== 'all') {
            $query->where('product_id', $this->filterProduct);
        }

        if ($this->filterStatus !== 'all') {
            $query->where('status', $this->filterStatus);
        }

        if ($this->filterCustomer !== 'all') {
            $query->where('customer_id', $this->filterCustomer);
        }

        // Sorting
        $query->orderBy($this->sortField, $this->sortDirection);

        return $query;
    }


    public function render()
    {
         $equipments = $this->getEquipmentsQuery()->paginate(15);

        // Stats
        $stats = [
            'total' => Equipment::count(),
            'available' => Equipment::where('status', 'available')->count(),
            'installed' => Equipment::where('status', 'installed')->count(),
            'maintenance' => Equipment::where('status', 'maintenance')->count(),
            'damaged' => Equipment::where('status', 'damaged')->count(),
            'lost' => Equipment::where('status', 'lost')->count(),
        ];

        // Status labels
        $statusLabels = [
            'available' => 'Disponível',
            'installed' => 'Instalado',
            'maintenance' => 'Manutenção',
            'damaged' => 'Avariado',
            'lost' => 'Perdido',
        ];

        return view('livewire.equipment-manager', [
            'equipments' => $equipments,
            'stats' => $stats,
            'statusLabels' => $statusLabels,
        ]);
    }
      public function boot()
    {
        // Disponibilizar variáveis para o layout via ViewData
        view()->share([
            'pageTitle' => 'Gestão de Equipamentos',
            'pageDescription' => 'Gerenciar equipamentos individuais',
            'breadcrumbs' => [
                ['label' => 'Serviços', 'url' => '#'],
                ['label' => 'Equipamentos', 'url' => '']
            ]
        ]);
    }
}
