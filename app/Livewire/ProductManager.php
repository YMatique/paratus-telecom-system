<?php

namespace App\Livewire;

use App\Livewire\Concerns\WithToast;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('livewire.layouts.app')]
#[Title('Gestão de Planos')]
class ProductManager extends Component
{
    use WithToast;
    use WithPagination;

    // Navegação e Estado
    public $activeTab = 'list'; // list, create, edit, stock
    public $selectedProduct = null;

    // Filtros
    public $search = '';
    public $filterCategory = 'all'; // all, modem, router, onu, antenna, cable, other
    public $filterStatus = 'all'; // all, active, inactive
    public $filterStock = 'all'; // all, in_stock, low_stock, out_of_stock
    public $sortField = 'name';
    public $sortDirection = 'asc';

    // Formulário Produto
    #[Validate('required|string|max:255')]
    public $name = '';

    #[Validate('nullable|string|max:100')]
    public $model = '';

    #[Validate('nullable|string|max:100')]
    public $brand = '';

    #[Validate('required|in:modem,router,onu,antenna,cable,other')]
    public $category = 'modem';

    #[Validate('nullable|string|max:1000')]
    public $description = '';

    #[Validate('nullable|numeric|min:0|max:999999.99')]
    public $sale_price = '';

    #[Validate('nullable|numeric|min:0|max:999999.99')]
    public $rental_price = '';

    #[Validate('required|integer|min:0|max:99999')]
    public $stock_quantity = 0;

    #[Validate('required|integer|min:1|max:999')]
    public $min_stock_alert = 5;

    #[Validate('boolean')]
    public $is_active = true;

    // Controle de Estoque
    public $showStockModal = false;
    public $stockAction = 'add'; // add, remove, adjust

    #[Validate('required|integer|min:1')]
    public $stockQuantity = 1;

    #[Validate('nullable|string|max:255')]
    public $stockReason = '';

    // Bulk Actions
    public $selectedProducts = [];

    protected $listeners = [
        'productDeleted' => '$refresh',
        'stockUpdated' => '$refresh',
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

    public function updatedFilterCategory()
    {
        $this->resetPage();
    }

    public function updatedFilterStatus()
    {
        $this->resetPage();
    }

    public function updatedFilterStock()
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
    // CRUD PRODUTOS
    // =====================================

    public function createProduct()
    {
        $this->resetProductForm();
        $this->activeTab = 'create';
    }

    public function editProduct($productId)
    {
        $product = Product::findOrFail($productId);
        $this->selectedProduct = $product;
        $this->fillProductForm($product);
        $this->activeTab = 'edit';
    }

    public function saveProduct()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'model' => $this->model,
            'brand' => $this->brand,
            'category' => $this->category,
            'description' => $this->description,
            'sale_price' => $this->sale_price ?: null,
            'rental_price' => $this->rental_price ?: null,
            'stock_quantity' => $this->stock_quantity,
            'min_stock_alert' => $this->min_stock_alert,
            'is_active' => $this->is_active,
        ];

        if ($this->selectedProduct) {
            // Update - manter quantidade atual se não mudou
            if ($this->stock_quantity == $this->selectedProduct->stock_quantity) {
                unset($data['stock_quantity']);
            }
            $this->selectedProduct->update($data);
            session()->flash('message', 'Produto atualizado com sucesso!');
        } else {
            // Create
            Product::create($data);
            session()->flash('message', 'Produto criado com sucesso!');
        }

        $this->resetProductForm();
        $this->activeTab = 'list';
    }

    public function deleteProduct($productId)
    {
        $product = Product::findOrFail($productId);
        
        // Verificar se tem equipamentos associados
        if ($product->equipment()->exists()) {
            session()->flash('error', 'Não é possível excluir produto com equipamentos cadastrados.');
            return;
        }

        $product->delete();
        session()->flash('message', 'Produto excluído com sucesso!');
    }

    public function toggleStatus($productId)
    {
        $product = Product::findOrFail($productId);
        $product->update(['is_active' => !$product->is_active]);
        
        $status = $product->is_active ? 'ativado' : 'desativado';
        session()->flash('message', "Produto {$status} com sucesso!");
    }

    public function duplicateProduct($productId)
    {
        $product = Product::findOrFail($productId);
        $newProduct = $product->replicate();
        $newProduct->name = $product->name . ' (Cópia)';
        $newProduct->stock_quantity = 0; // Nova cópia sem estoque
        $newProduct->is_active = false;
        $newProduct->save();

        session()->flash('message', 'Produto duplicado com sucesso!');
    }

    // =====================================
    // CONTROLE DE ESTOQUE
    // =====================================

    public function openStockModal($productId, $action = 'add')
    {
        $this->selectedProduct = Product::findOrFail($productId);
        $this->stockAction = $action;
        $this->stockQuantity = 1;
        $this->stockReason = '';
        $this->showStockModal = true;
        $this->resetErrorBag(['stockQuantity', 'stockReason']);
    }

    public function updateStock()
    {
        $this->validate([
            'stockQuantity' => 'required|integer|min:1',
            'stockReason' => 'nullable|string|max:255',
        ]);

        $currentStock = $this->selectedProduct->stock_quantity;
        $newStock = $currentStock;

        switch ($this->stockAction) {
            case 'add':
                $newStock = $currentStock + $this->stockQuantity;
                $action = "Adicionado {$this->stockQuantity} unidades";
                break;
                
            case 'remove':
                if ($this->stockQuantity > $currentStock) {
                    $this->addError('stockQuantity', 'Quantidade maior que estoque disponível.');
                    return;
                }
                $newStock = $currentStock - $this->stockQuantity;
                $action = "Removido {$this->stockQuantity} unidades";
                break;
                
            case 'adjust':
                $newStock = $this->stockQuantity;
                $action = "Ajustado para {$this->stockQuantity} unidades";
                break;
        }

        $this->selectedProduct->update(['stock_quantity' => $newStock]);

        // Aqui poderia logar a movimentação no futuro
        // StockMovement::create([...])

        session()->flash('message', "{$action}. Estoque atual: {$newStock}");
        $this->showStockModal = false;
        $this->selectedProduct = null;
    }

    // =====================================
    // BULK ACTIONS
    // =====================================

    public function selectAllProducts()
    {
        $this->selectedProducts = $this->getProductsQuery()->pluck('id')->toArray();
    }

    public function bulkActivate()
    {
        Product::whereIn('id', $this->selectedProducts)->update(['is_active' => true]);
        $this->selectedProducts = [];
        session()->flash('message', 'Produtos ativados com sucesso!');
    }

    public function bulkDeactivate()
    {
        Product::whereIn('id', $this->selectedProducts)->update(['is_active' => false]);
        $this->selectedProducts = [];
        session()->flash('message', 'Produtos desativados com sucesso!');
    }

    // =====================================
    // HELPERS
    // =====================================

    private function resetProductForm()
    {
        $this->reset([
            'name', 'model', 'brand', 'category', 'description',
            'sale_price', 'rental_price', 'stock_quantity', 'min_stock_alert', 'is_active'
        ]);
        $this->selectedProduct = null;
        $this->category = 'modem';
        $this->is_active = true;
        $this->stock_quantity = 0;
        $this->min_stock_alert = 5;
        $this->resetErrorBag();
    }

    private function fillProductForm(Product $product)
    {
        $this->name = $product->name;
        $this->model = $product->model;
        $this->brand = $product->brand;
        $this->category = $product->category;
        $this->description = $product->description;
        $this->sale_price = $product->sale_price;
        $this->rental_price = $product->rental_price;
        $this->stock_quantity = $product->stock_quantity;
        $this->min_stock_alert = $product->min_stock_alert;
        $this->is_active = $product->is_active;
    }

    // Query Builder
    private function getProductsQuery()
    {
        $query = Product::query();

        // Search
        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('model', 'like', '%' . $this->search . '%')
                  ->orWhere('brand', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        // Filters
        if ($this->filterCategory !== 'all') {
            $query->where('category', $this->filterCategory);
        }

        if ($this->filterStatus !== 'all') {
            $query->where('is_active', $this->filterStatus === 'active');
        }

        if ($this->filterStock !== 'all') {
            switch ($this->filterStock) {
                case 'in_stock':
                    $query->where('stock_quantity', '>', 0);
                    break;
                case 'low_stock':
                    $query->whereRaw('stock_quantity <= min_stock_alert');
                    break;
                case 'out_of_stock':
                    $query->where('stock_quantity', 0);
                    break;
            }
        }

        // Sorting
        $query->orderBy($this->sortField, $this->sortDirection);

        return $query;
    }
    public function render()
    {
         $products = $this->getProductsQuery()->paginate(15);

        // Stats
        $stats = [
            'total' => Product::count(),
            'active' => Product::where('is_active', true)->count(),
            'in_stock' => Product::where('stock_quantity', '>', 0)->count(),
            'low_stock' => Product::whereRaw('stock_quantity <= min_stock_alert')->count(),
            'out_of_stock' => Product::where('stock_quantity', 0)->count(),
            'total_value' => Product::whereNotNull('sale_price')->sum(DB::raw('stock_quantity * sale_price')),
        ];

        // Categorias para filtro
        $categories = [
            'modem' => 'Modems',
            'router' => 'Roteadores', 
            'onu' => 'ONUs',
            'antenna' => 'Antenas',
            'cable' => 'Cabos',
            'other' => 'Outros',
        ];

        return view('livewire.product-manager', [
            'products' => $products,
            'stats' => $stats,
            'categories' => $categories,
        ]);
    }
        public function boot()
    {
        // Disponibilizar variáveis para o layout via ViewData
        view()->share([
            'pageTitle' => 'Gestão de Produtos',
            'pageDescription' => 'Gerenciar produtos',
            'breadcrumbs' => [
                ['label' => 'Serviços', 'url' => '#'],
                ['label' => 'Produtos', 'url' => '']
            ]
        ]);
    }
}
