<?php

namespace App\Livewire\Customer\Invoices;

use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('livewire.layouts.customer-portal')]
#[Title('Minhas Faturas - Portal do Cliente')]
class Index extends Component
{
     use WithPagination;

    public $customer;
    public $filterStatus = 'all'; // all, pending, paid, overdue, cancelled
    public $search = '';

    public function mount()
    {
        $this->customer = Auth::guard('customer')->user();
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
     * Limpar busca
     */
    public function clearSearch()
    {
        $this->search = '';
        $this->resetPage();
    }

    /**
     * Buscar faturas
     */
    #[Computed]
    public function invoices()
    {
        $query = Invoice::whereHas('subscription', function($q) {
                $q->where('customer_id', $this->customer->id);
            })
            ->with(['subscription.plan']);

        // Filtro de status
        if ($this->filterStatus !== 'all') {
            $query->where('status', $this->filterStatus);
        }

        // Busca por número de fatura
        if ($this->search) {
            $query->where('invoice_number', 'like', '%' . $this->search . '%');
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
        $baseQuery = Invoice::whereHas('subscription', function($q) {
            $q->where('customer_id', $this->customer->id);
        });

        return [
            'all' => (clone $baseQuery)->count(),
            'pending' => (clone $baseQuery)->where('status', 'pending')->count(),
            'paid' => (clone $baseQuery)->where('status', 'paid')->count(),
            'overdue' => (clone $baseQuery)->where('status', 'overdue')->count(),
            'cancelled' => (clone $baseQuery)->where('status', 'cancelled')->count(),
        ];
    }

    /**
     * Ver detalhes da fatura
     */
    public function viewInvoice($invoiceId)
    {
        return $this->redirect(route('customer.invoices.show', $invoiceId), navigate: true);
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
        return view('livewire.customer.invoices.index',[
            'invoices' => $this->invoices,
            'statusCounts' => $this->statusCounts,
        ]);
    }
}
