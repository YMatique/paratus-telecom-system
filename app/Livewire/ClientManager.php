<?php

namespace App\Livewire;

use App\Livewire\Concerns\WithToast;
use Livewire\Component;

class ClientManager extends Component
{
     use WithToast;

    public function save()
    {
        // Validação e salvamento...
        
        $this->toastSuccess('Cliente salvo!', 'Dados atualizados com sucesso.');
    }

    public function render()
    {
        return view('livewire.client-manager');
    }
}
