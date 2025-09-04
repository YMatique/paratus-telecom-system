<?php

namespace App\Livewire;

use Livewire\Component;
use App\Livewire\Concerns\WithToast;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Payment;
use App\Models\Subscription;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\WithPagination;
use Carbon\Carbon;

#[Layout('livewire.layouts.app')]
#[Title('Gestão de Faturas')]
class InvoiceManager extends Component
{
     use WithToast, WithPagination;

    protected $queryString = [
        'search' => ['except' => ''],
        'filterStatus' => ['except' => 'all'],
        'filterCustomer' => ['except' => 'all'],
        'filterDueDate' => ['except' => 'all'],
    ];

     // Tabs/Estados da interface
    public $activeTab = 'list'; // list, create, view, payment
    public $selectedInvoice = null;

    // Filtros da listagem
    public $search = '';
    public $filterStatus = 'all'; // all, pending, paid, overdue, cancelled
    public $filterCustomer = 'all';
    public $filterDueDate = 'all'; // all, due_today, due_week, overdue
    public $sortField = 'issue_date';
    public $sortDirection = 'desc';

    // Dados para Criação de Fatura
    #[Validate('required|exists:customers,id')]
    public $customer_id = '';
    
    #[Validate('nullable|exists:subscriptions,id')]
    public $subscription_id = '';
    
    #[Validate('required|date')]
    public $issue_date = '';
    
    #[Validate('required|date|after_or_equal:issue_date')]
    public $due_date = '';
    
    #[Validate('required|numeric|min:0')]
    public $subtotal = 0;
    
    #[Validate('required|numeric|min:0')]
    public $tax_amount = 0;
    
    #[Validate('nullable|numeric|min:0')]
    public $discount_amount = 0;
    
    #[Validate('required|numeric|min:0')]
    public $total_amount = 0;
    
    #[Validate('nullable|string|max:1000')]
    public $notes = '';

    // Itens da fatura
    public $invoiceItems = [];
    public $newItem = [
        'description' => '',
        'quantity' => 1,
        'unit_price' => 0,
        'type' => 'plan'
    ];

    // Dados para registro de pagamento
    #[Validate('required|numeric|min:0')]
    public $payment_amount = 0;
    
    #[Validate('required|in:cash,bank_transfer,mpesa,emola,mkesh,card')]
    public $payment_method = 'mpesa';
    
    #[Validate('nullable|string|max:255')]
    public $payment_reference = '';
    
    #[Validate('required|date')]
    public $payment_date = '';
    
    #[Validate('nullable|string|max:500')]
    public $payment_notes = '';

    // Dados auxiliares
    public $customers = [];
    public $subscriptions = [];
    public $selectedCustomer = null;

    // Ações em massa
    public $selectedInvoices = [];
    public $bulkAction = '';

    protected $listeners = [
        'invoiceUpdated' => '$refresh',
        'paymentRegistered' => '$refresh',
    ];

    public function mount()
    {
        $this->issue_date = now()->toDateString();
        $this->due_date = now()->addDays(10)->toDateString();
        $this->payment_date = now()->toDateString();
        $this->loadSelectData();
    }

    public function loadSelectData()
    {
        $this->customers = Customer::active()
            ->orderBy('name')
            ->get(['id', 'name', 'document', 'type']);
    }

    // === TAB NAVIGATION ===
    public function goToList()
    {
        $this->activeTab = 'list';
        $this->resetForm();
    }

    public function createInvoice()
    {
        $this->activeTab = 'create';
        $this->resetForm();
        $this->loadSelectData();
    }

    public function viewInvoice($invoiceId)
    {
        $this->selectedInvoice = Invoice::with([
            'customer', 'subscription.plan', 'items', 
            'payments' => function($q) { $q->latest(); }
        ])->findOrFail($invoiceId);
        
        $this->activeTab = 'view';
    }

    public function showPaymentForm($invoiceId)
    {
        $this->selectedInvoice = Invoice::with('customer')->findOrFail($invoiceId);
        $this->payment_amount = $this->selectedInvoice->getRemainingAmount();
        $this->payment_date = now()->toDateString();
        $this->activeTab = 'payment';
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
            // dd($this->subscriptions);
            // Auto-selecionar subscrição ativa se houver apenas uma
            if ($this->subscriptions->count() === 1) {
                $this->subscription_id = $this->subscriptions->first()->id;
                // $this->updatedSubscriptionId($this->subscription_id);
                // $this->loadSubscriptionData($this->subscription_id);
            }
        } else {
            $this->subscriptions = [];
            $this->selectedCustomer = null;
        }
    }

    public function updatedSubscriptionId($subscriptionId)
    {
        if ($subscriptionId) {
            $this->loadSubscriptionData($subscriptionId);
        }
    }

    private function loadSubscriptionData($subscriptionId)
    {
        $subscription = Subscription::with('plan')->find($subscriptionId);
        
        if ($subscription) {
            // Pre-popular com dados da subscrição
            $this->addSubscriptionItem($subscription);
            $this->calculateTotals();

        }
    }

    private function addSubscriptionItem($subscription)
    {
        $this->invoiceItems[] = [
            'description' => $subscription->plan->name . ' - ' . now()->format('m/Y'),
            'quantity' => 1,
            'unit_price' => $subscription->monthly_price,
            'total_price' => $subscription->monthly_price,
            'type' => 'plan'
        ];
    }

    // === INVOICE ITEMS ===
    public function addItem()
    {
        $this->validate([
            'newItem.description' => 'required|string|max:255',
            'newItem.quantity' => 'required|integer|min:1',
            'newItem.unit_price' => 'required|numeric|min:0',
        ]);

        $totalPrice = $this->newItem['quantity'] * $this->newItem['unit_price'];

        $this->invoiceItems[] = [
            'description' => $this->newItem['description'],
            'quantity' => $this->newItem['quantity'],
            'unit_price' => $this->newItem['unit_price'],
            'total_price' => $totalPrice,
            'type' => $this->newItem['type']
        ];

        // Reset form
        $this->newItem = [
            'description' => '',
            'quantity' => 1,
            'unit_price' => 0,
            'type' => 'plan'
        ];

        $this->calculateTotals();
    }

    public function removeItem($index)
    {
        unset($this->invoiceItems[$index]);
        $this->invoiceItems = array_values($this->invoiceItems); // Reindexar array
        $this->calculateTotals();
    }

    public function calculateTotals()
    {
        $this->subtotal = collect($this->invoiceItems)->sum('total_price');
        $this->tax_amount = $this->subtotal * 0.17; // IVA 17%
        $this->total_amount = $this->subtotal + $this->tax_amount - $this->discount_amount;
    }

    // === INVOICE OPERATIONS ===
    public function saveInvoice()
    {
        $this->validate();

        if (empty($this->invoiceItems)) {
            $this->toastError('Adicione pelo menos um item à fatura');
            return;
        }

        try {
            DB::transaction(function () {
                // Gerar número da fatura
                $invoiceNumber = $this->generateInvoiceNumber();

                // Criar fatura
                $invoice = Invoice::create([
                    'invoice_number' => $invoiceNumber,
                    'customer_id' => $this->customer_id,
                    'subscription_id' => $this->subscription_id ?: null,
                    'issue_date' => $this->issue_date,
                    'due_date' => $this->due_date,
                    'subtotal' => $this->subtotal,
                    'tax_amount' => $this->tax_amount,
                    'discount_amount' => $this->discount_amount,
                    'total_amount' => $this->total_amount,
                    'status' => 'pending',
                    'notes' => $this->notes,
                ]);

                // Criar itens da fatura
                foreach ($this->invoiceItems as $item) {
                    InvoiceItem::create([
                        'invoice_id' => $invoice->id,
                        'description' => $item['description'],
                        'quantity' => $item['quantity'],
                        'unit_price' => $item['unit_price'],
                        'total_price' => $item['total_price'],
                        'type' => $item['type'],
                    ]);
                }

                // Atualizar subscrição se aplicável
                if ($this->subscription_id) {
                    $subscription = Subscription::find($this->subscription_id);
                    $subscription->update([
                        'last_invoice_date' => now(),
                        'next_invoice_date' => now()->addMonth()->day($subscription->billing_day)
                    ]);
                }

                $this->toastSuccess('Fatura criada com sucesso!', "Número: {$invoiceNumber}");
            });

            $this->goToList();
        } catch (\Exception $e) {
            $this->toastError('Erro ao criar fatura', $e->getMessage());
        }
    }

    private function generateInvoiceNumber()
    {
        $year = now()->year;
        $month = now()->format('m');
        $sequence = Invoice::whereYear('issue_date', $year)
                          ->whereMonth('issue_date', $month)
                          ->count() + 1;

        return "INV-{$year}{$month}-" . str_pad($sequence, 4, '0', STR_PAD_LEFT);
    }

    // === PAYMENT OPERATIONS ===
    public function registerPayment()
    {
        $this->validate([
            'payment_amount' => 'required|numeric|min:0.01',
            'payment_method' => 'required|in:cash,bank_transfer,mpesa,emola,mkesh,card',
            'payment_date' => 'required|date',
        ]);

        if ($this->payment_amount > $this->selectedInvoice->getRemainingAmount()) {
            $this->toastError('Valor do pagamento não pode ser maior que o saldo devedor');
            return;
        }

        try {
            DB::transaction(function () {
                // Criar pagamento
                $payment = Payment::create([
                    'customer_id' => $this->selectedInvoice->customer_id,
                    'invoice_id' => $this->selectedInvoice->id,
                    'amount' => $this->payment_amount,
                    'method' => $this->payment_method,
                    'reference' => $this->payment_reference,
                    'payment_date' => $this->payment_date,
                    'status' => 'confirmed',
                    'notes' => $this->payment_notes,
                ]);

                // Verificar se fatura foi totalmente paga
                $totalPaid = $this->selectedInvoice->payments()
                    ->where('status', 'confirmed')
                    ->sum('amount');

                if ($totalPaid >= $this->selectedInvoice->total_amount) {
                    $this->selectedInvoice->update([
                        'status' => 'paid',
                        'paid_date' => $this->payment_date
                    ]);
                }

                $this->toastSuccess('Pagamento registrado com sucesso!');
            });

            $this->viewInvoice($this->selectedInvoice->id);
        } catch (\Exception $e) {
            $this->toastError('Erro ao registrar pagamento', $e->getMessage());
        }
    }

    // === INVOICE ACTIONS ===
    public function cancelInvoice($invoiceId)
    {
        try {
            $invoice = Invoice::findOrFail($invoiceId);
            
            if ($invoice->isPaid()) {
                $this->toastError('Não é possível cancelar uma fatura paga');
                return;
            }

            $invoice->update(['status' => 'cancelled']);
            $this->toastSuccess('Fatura cancelada com sucesso!');
        } catch (\Exception $e) {
            $this->toastError('Erro ao cancelar fatura');
        }
    }

    public function duplicateInvoice($invoiceId)
    {
        try {
            $originalInvoice = Invoice::with('items')->findOrFail($invoiceId);
            
            $this->customer_id = $originalInvoice->customer_id;
            $this->subscription_id = $originalInvoice->subscription_id;
            
            // Copiar itens
            $this->invoiceItems = [];
            foreach ($originalInvoice->items as $item) {
                $this->invoiceItems[] = [
                    'description' => $item->description,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->unit_price,
                    'total_price' => $item->total_price,
                    'type' => $item->type,
                ];
            }
            
            $this->calculateTotals();
            $this->createInvoice();
            
            $this->toastInfo('Fatura duplicada. Revise os dados antes de salvar.');
        } catch (\Exception $e) {
            $this->toastError('Erro ao duplicar fatura');
        }
    }

    // === BULK ACTIONS ===
    public function executeBulkAction()
    {
        if (empty($this->selectedInvoices) || empty($this->bulkAction)) {
            $this->toastWarning('Selecione faturas e uma ação');
            return;
        }

        try {
            $count = count($this->selectedInvoices);
            
            switch ($this->bulkAction) {
                case 'mark_overdue':
                    Invoice::whereIn('id', $this->selectedInvoices)
                        ->where('status', 'pending')
                        ->where('due_date', '<', now())
                        ->update(['status' => 'overdue']);
                    $this->toastSuccess("$count faturas marcadas como vencidas");
                    break;
                    
                case 'cancel':
                    Invoice::whereIn('id', $this->selectedInvoices)
                        ->where('status', 'pending')
                        ->update(['status' => 'cancelled']);
                    $this->toastSuccess("$count faturas canceladas");
                    break;
            }

            $this->selectedInvoices = [];
            $this->bulkAction = '';
        } catch (\Exception $e) {
            $this->toastError('Erro na ação em massa');
        }
    }

    // === HELPERS ===
    private function resetForm()
    {
        $this->reset([
            'customer_id', 'subscription_id', 'issue_date', 'due_date',
            'subtotal', 'tax_amount', 'discount_amount', 'total_amount',
            'notes', 'invoiceItems', 'payment_amount', 'payment_method',
            'payment_reference', 'payment_date', 'payment_notes'
        ]);
        
        $this->selectedInvoice = null;
        $this->selectedCustomer = null;
        $this->subscriptions = [];
        $this->issue_date = now()->toDateString();
        $this->due_date = now()->addDays(10)->toDateString();
        $this->payment_date = now()->toDateString();
        
        $this->newItem = [
            'description' => '',
            'quantity' => 1,
            'unit_price' => 0,
            'type' => 'plan'
        ];
    }

    // === QUERY BUILDER ===
    private function getInvoicesQuery()
    {
        $query = Invoice::with(['customer', 'subscription.plan']);

        // Search
        if ($this->search) {
            $query->where(function($q) {
                $q->where('invoice_number', 'like', '%' . $this->search . '%')
                  ->orWhereHas('customer', function($customerQuery) {
                      $customerQuery->where('name', 'like', '%' . $this->search . '%')
                                   ->orWhere('document', 'like', '%' . $this->search . '%');
                  });
            });
        }

        // Filters
        if ($this->filterStatus !== 'all') {
            if ($this->filterStatus === 'overdue') {
                $query->where('status', 'pending')->where('due_date', '<', now());
            } else {
                $query->where('status', $this->filterStatus);
            }
        }

        if ($this->filterCustomer !== 'all') {
            $query->where('customer_id', $this->filterCustomer);
        }

        if ($this->filterDueDate === 'due_today') {
            $query->where('due_date', now()->toDateString());
        } elseif ($this->filterDueDate === 'due_week') {
            $query->whereBetween('due_date', [now()->toDateString(), now()->addWeek()->toDateString()]);
        } elseif ($this->filterDueDate === 'overdue') {
            $query->where('status', 'pending')->where('due_date', '<', now());
        }

        // Sorting
        $query->orderBy($this->sortField, $this->sortDirection);

        return $query;
    }

    public function render()
    {
        $invoices = $this->getInvoicesQuery()->paginate(15);

        // Stats para cards
        $stats = [
            'total_invoices' => Invoice::count(),
            'pending_amount' => Invoice::where('status', 'pending')->sum('total_amount'),
            'paid_amount' => Invoice::where('status', 'paid')->sum('total_amount'),
            'overdue_count' => Invoice::where('status', 'pending')
                ->where('due_date', '<', now())
                ->count(),
            'due_today' => Invoice::where('status', 'pending')
                ->where('due_date', now()->toDateString())
                ->count(),
            'monthly_revenue' => Payment::where('status', 'confirmed')
                ->whereMonth('payment_date', now()->month)
                ->sum('amount'),
        ];

        return view('livewire.invoice-manager', [
            'invoices' => $invoices,
            'stats' => $stats,
        ]);
    }
     public function boot()
    {
        view()->share([
            'pageTitle' => 'Gestão de Faturas',
            'pageDescription' => 'Gerenciar faturas, cobranças e pagamentos',
            'breadcrumbs' => [
                ['label' => 'Financeiro', 'url' => '#'],
                ['label' => 'Faturas', 'url' => '']
            ]
        ]);
    }
    
}
