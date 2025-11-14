<?php

namespace App\Livewire\Customer\Plans;

use App\Models\Plan;
use App\Models\Subscription;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Computed;
use Livewire\Component;




#[Layout('livewire.layouts.customer-portal')]
#[Title('Planos Disponíveis - Portal do Cliente')]
class Index extends Component
{
     public $customer;
    public $selectedSubscriptionId = null;
    public $filterType = 'all'; // all, residential, business
    
    // Modal de Upgrade
    public $showUpgradeModal = false;
    public $selectedPlan = null;
    public $upgradeReason = '';

    public function mount()
    {
        $this->customer = Auth::guard('customer')->user();
        
        // Se o cliente tem apenas uma subscrição ativa, seleciona automaticamente
        $activeSubscriptions = $this->customer->subscriptions()->where('status', 'active')->get();
        if ($activeSubscriptions->count() === 1) {
            $this->selectedSubscriptionId = $activeSubscriptions->first()->id;
        }
    }

    /**
     * Buscar subscrições ativas do cliente
     */
    #[Computed]
    public function activeSubscriptions()
    {
        return $this->customer->subscriptions()
            ->where('status', 'active')
            ->with('plan')
            ->get();
    }

    /**
     * Buscar subscrição selecionada
     */
    #[Computed]
    public function selectedSubscription()
    {
        if (!$this->selectedSubscriptionId) {
            return null;
        }

        return Subscription::with('plan')
            ->where('customer_id', $this->customer->id)
            ->find($this->selectedSubscriptionId);
    }

    /**
     * Buscar planos disponíveis
     */
    #[Computed]
    public function plans()
    {
        $query = Plan::where('is_active', true);

        // Filtro por tipo
        if ($this->filterType !== 'all') {
            $query->where('type', $this->filterType);
        }

        return $query->orderBy('price', 'asc')->get();
    }

    /**
     * Verificar se o plano é upgrade
     */
    public function isUpgrade($plan)
    {
        if (!$this->selectedSubscription) {
            return true;
        }

        $currentPlan = $this->selectedSubscription->plan;
        
        // Considera upgrade se:
        // 1. Velocidade de download é maior
        // 2. OU preço é maior (planos premium)
        return $plan->download_speed > $currentPlan->download_speed 
            || $plan->price > $currentPlan->price;
    }

    /**
     * Verificar se é o plano atual
     */
    public function isCurrentPlan($plan)
    {
        if (!$this->selectedSubscription) {
            return false;
        }

        return $this->selectedSubscription->plan_id === $plan->id;
    }

    /**
     * Abrir modal de upgrade
     */
    public function openUpgradeModal($planId)
    {
        if (!$this->selectedSubscriptionId) {
            session()->flash('error', 'Por favor, selecione uma subscrição primeiro.');
            return;
        }

        $this->selectedPlan = Plan::findOrFail($planId);
        $this->showUpgradeModal = true;
        $this->upgradeReason = '';
    }

    /**
     * Fechar modal
     */
    public function closeUpgradeModal()
    {
        $this->showUpgradeModal = false;
        $this->selectedPlan = null;
        $this->upgradeReason = '';
    }

    /**
     * Solicitar upgrade
     */
    public function requestUpgrade()
    {
        $this->validate([
            'upgradeReason' => 'required|string|min:10|max:500',
        ], [
            'upgradeReason.required' => 'Por favor, informe o motivo da solicitação.',
            'upgradeReason.min' => 'O motivo deve ter pelo menos 10 caracteres.',
        ]);

        if (!$this->selectedSubscription || !$this->selectedPlan) {
            session()->flash('error', 'Dados inválidos para solicitação.');
            return;
        }

        // Criar ticket de solicitação de upgrade
        $ticket = $this->customer->tickets()->create([
            'ticket_number' => 'TKT-' . strtoupper(uniqid()),
            'subscription_id' => $this->selectedSubscriptionId,
            'subject' => 'Solicitação de Upgrade - ' . $this->selectedPlan->name,
            'description' => "Solicitação de upgrade do plano atual ({$this->selectedSubscription->plan->name}) para o plano {$this->selectedPlan->name}.\n\nMotivo: {$this->upgradeReason}",
            'priority' => 'normal',
            'category' => 'upgrade',
            'status' => 'open',
            'opened_at' => now(),
        ]);

        $this->closeUpgradeModal();

        session()->flash('success', 'Solicitação enviada com sucesso! Em breve nossa equipe entrará em contato.');

        return $this->redirect(route('customer.tickets.show', $ticket->id), navigate: true);
    }

    /**
     * Filtrar por tipo de plano
     */
    public function filterByType($type)
    {
        $this->filterType = $type;
    }

    /**
     * Selecionar subscrição
     */
    public function selectSubscription($subscriptionId)
    {
        $this->selectedSubscriptionId = $subscriptionId;
    }
    public function render()
    {
        return view('livewire.customer.plans.index',[
            'activeSubscriptions' => $this->activeSubscriptions,
            'selectedSubscription' => $this->selectedSubscription,
            'plans' => $this->plans,
        ]);
    }
}
