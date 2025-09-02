<?php

namespace App\Livewire;

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
        return view('livewire.dashboard');
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
