<?php

namespace App\Livewire\Customer\Subscriptions;

use App\Models\Subscription;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.customer-portal')]
#[Title('Minhas Subscrições - Portal do Cliente')]
class Index extends Component
{
     use WithPagination;

    public $customer;
    public $filterStatus = 'all'; // all, active, suspended, cancelled

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
     * Buscar subscrições
     */
    #[Computed]
    public function subscriptions()
    {
        $query = Subscription::where('customer_id', $this->customer->id)
            ->with(['plan', 'installationAddress', 'subscriptionProducts.product']);

        // Filtro de status
        if ($this->filterStatus !== 'all') {
            $query->where('status', $this->filterStatus);
        }

        return $query->orderBy('created_at', 'desc')
            ->paginate(10);
    }

    /**
     * Contador por status
     */
    #[Computed]
    public function statusCounts()
    {
        return [
            'all' => Subscription::where('customer_id', $this->customer->id)->count(),
            'active' => Subscription::where('customer_id', $this->customer->id)->where('status', 'active')->count(),
            'suspended' => Subscription::where('customer_id', $this->customer->id)->where('status', 'suspended')->count(),
            'cancelled' => Subscription::where('customer_id', $this->customer->id)->where('status', 'cancelled')->count(),
        ];
    }

    /**
     * Ver detalhes da subscrição
     */
    public function viewDetails($subscriptionId)
    {
        return $this->redirect(route('customer.subscriptions.show', $subscriptionId), navigate: true);
    }

    public function render()
    {
        return view('livewire.customer.subscriptions.index', [
            'subscriptions' => $this->subscriptions,
            'statusCounts' => $this->statusCounts,
        ]);
    }
}
