<?php

namespace App\Livewire;

use App\Livewire\Concerns\WithToast;
use Livewire\Attributes\Layout;
use Livewire\Component;

class ClientManager extends Component
{
     use WithToast;
    #[Layout('livewire.layouts.app')]
    public function save()
    {
        // Validação e salvamento...
        
        $this->toastSuccess('Cliente salvo!', 'Dados atualizados com sucesso.');
    }

    public function render()
    {
        return view('livewire.client-manager');
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
