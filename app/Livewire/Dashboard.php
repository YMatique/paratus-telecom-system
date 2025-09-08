<?php

namespace App\Livewire;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Subscription;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Dashboard extends Component
{
    public $pageTitle = 'Gestão de Clientes';
    public $pageDescription = 'Cadastrar e gerenciar clientes do sistema';
    public $breadcrumbs = [
        ['label' => 'Clientes', 'url' => '#'],
        ['label' => 'Lista de Clientes', 'url' => '']
    ];
    #[Layout('livewire.layouts.app')]
    public function render()
    {
         // Buscar dados reais
        $stats = $this->getStats();
        $recentCustomers = $this->getRecentCustomers();
        $recentTickets = $this->getRecentTickets(); // Placeholder por enquanto
        
        return view('livewire.dashboard',  compact('stats', 'recentCustomers', 'recentTickets'));
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
private function getStats()
    {
        // Total de Clientes
        $totalCustomers = Customer::count();
        $customersLastMonth = Customer::whereMonth('created_at', now()->subMonth())->count();
        $customersGrowth = $customersLastMonth > 0 ? 
            round((($totalCustomers - $customersLastMonth) / $customersLastMonth) * 100, 1) : 0;

        // Subscrições Ativas
        $activeSubscriptions = Subscription::where('status', 'active')->count();
        $subscriptionsLastMonth = Subscription::where('status', 'active')
            ->whereMonth('start_date', '<=', now()->subMonth())
            ->count();
        $subscriptionsGrowth = $subscriptionsLastMonth > 0 ? 
            round((($activeSubscriptions - $subscriptionsLastMonth) / $subscriptionsLastMonth) * 100, 1) : 0;

        // Receita do Mês
        $monthlyRevenue = Invoice::whereMonth('issue_date', now())
            ->whereYear('issue_date', now())
            ->sum('total_amount');
        $lastMonthRevenue = Invoice::whereMonth('issue_date', now()->subMonth())
            ->whereYear('issue_date', now()->subMonth())
            ->sum('total_amount');
        $revenueGrowth = $lastMonthRevenue > 0 ? 
            round((($monthlyRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100, 1) : 0;

        // Tickets (Placeholder até implementar)
        $openTickets = 0; // TODO: Ticket::where('status', 'open')->count();
        $ticketsGrowth = 0; // TODO: calcular crescimento

        return [
            'customers' => [
                'total' => $totalCustomers,
                'growth' => $customersGrowth,
                'growth_positive' => $customersGrowth >= 0
            ],
            'subscriptions' => [
                'active' => $activeSubscriptions,
                'growth' => $subscriptionsGrowth,
                'growth_positive' => $subscriptionsGrowth >= 0
            ],
            'revenue' => [
                'monthly' => $monthlyRevenue,
                'formatted' => $this->formatCurrency($monthlyRevenue),
                'growth' => $revenueGrowth,
                'growth_positive' => $revenueGrowth >= 0
            ],
            'tickets' => [
                'open' => $openTickets,
                'growth' => $ticketsGrowth,
                'growth_positive' => $ticketsGrowth <= 0 // Para tickets, menos é melhor
            ]
        ];
    }

    private function getRecentCustomers()
    {
        try {
            return Customer::orderBy('created_at', 'desc')
                ->limit(3)
                ->get()
                ->map(function ($customer) {
                    return [
                        'id' => $customer->id,
                        'name' => $customer->name,
                        'email' => $customer->email ?? 'Não informado',
                        'initials' => $this->getInitials($customer->name),
                        'status' => $customer->status ?? 'active',
                        'status_label' => $this->getStatusLabel($customer->status ?? 'active'),
                        'status_color' => $this->getStatusColor($customer->status ?? 'active')
                    ];
                });
        } catch (\Exception $e) {
            return collect([]);
        }
    }

    private function getRecentTickets()
    {
        // TODO: Implementar quando tiver sistema de tickets
        // Por enquanto, retorna dados de exemplo
        return collect([
            [
                'id' => 'TK-2024-001',
                'subject' => 'Internet lenta - Cliente: ' . (Customer::first()->name ?? 'N/A'),
                'priority' => 'urgent',
                'priority_label' => 'Urgente',
                'priority_color' => 'red'
            ],
            [
                'id' => 'TK-2024-002', 
                'subject' => 'Problema de billing - Cliente: ' . (Customer::skip(1)->first()->name ?? 'N/A'),
                'priority' => 'medium',
                'priority_label' => 'Médio',
                'priority_color' => 'yellow'
            ],
            [
                'id' => 'TK-2024-003',
                'subject' => 'Solicitação de upgrade - Cliente: ' . (Customer::skip(2)->first()->name ?? 'N/A'),
                'priority' => 'low',
                'priority_label' => 'Baixo', 
                'priority_color' => 'green'
            ]
        ]);
    }

    private function formatCurrency($amount)
    {
        if ($amount >= 1000000) {
            return number_format($amount / 1000000, 1) . 'M MT';
        } elseif ($amount >= 1000) {
            return number_format($amount / 1000, 0) . 'K MT';
        } else {
            return number_format($amount, 0) . ' MT';
        }
    }

    private function getInitials($name)
    {
        $words = explode(' ', $name);
        if (count($words) >= 2) {
            return strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
        }
        return strtoupper(substr($name, 0, 2));
    }

    private function getStatusLabel($status)
    {
        return match($status) {
            'active' => 'Ativo',
            'suspended' => 'Suspenso',
            'inactive' => 'Inativo',
            'pending_installation' => 'Pendente',
            default => 'Desconhecido'
        };
    }

    private function getStatusColor($status)
    {
        return match($status) {
            'active' => 'green',
            'suspended' => 'red',
            'inactive' => 'gray',
            'pending_installation' => 'yellow',
            default => 'gray'
        };
    }

    // Ações rápidas
    public function redirectToCustomers()
    {
        return redirect()->route('customers');
    }

    public function redirectToSubscriptions()
    {
        return redirect()->route('subscriptions');
    }

    public function redirectToInvoices() 
    {
        return redirect()->route('invoices');
    }

    public function redirectToTickets()
    {
        return redirect()->route('tickets');
    }
}
