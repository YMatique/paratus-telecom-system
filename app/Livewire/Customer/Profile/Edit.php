<?php

namespace App\Livewire\Customer\Profile;

use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Computed;
use Livewire\Component;

#[Layout('livewire.layouts.customer-portal')]
#[Title('Meu Perfil')]

class Edit extends Component
{
    public Customer $customer;

    // Formulário de perfil
    public $name;
    public $email;
    public $phone;
    public $whatsapp;

    // Formulário de senha
    public $current_password;
    public $password;
    public $password_confirmation;

    public $showPasswordForm = false;

    public function mount()
    {
        $this->customer = Auth::guard('customer')->user();
        $this->fill($this->customer->only(['name', 'email', 'phone', 'whatsapp']));
    }

    #[Computed]
    public function activeSubscription()
    {
        return $this->customer->subscriptions()
            ->with(['plan', 'installationAddress', 'subscriptionProducts.product', 'subscriptionProducts.equipment'])
            ->where('status', 'active')
            ->first();
    }

    #[Computed]
    public function installationAddress()
    {
        return $this->customer->addresses()->where('type', 'installation')->first();
    }

    #[Computed]
    public function billingAddress()
    {
        return $this->customer->addresses()->where('type', 'billing')->first();
    }

    public function updateProfile()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:customers,email,' . $this->customer->id,
            'phone' => 'nullable|string|max:20',
            'whatsapp' => 'nullable|string|max:20',
        ]);

        $this->customer->update([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'whatsapp' => $this->whatsapp,
        ]);

        $this->dispatch('profile-updated');
    }

    public function updatePassword()
    {
        $this->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        if (!Hash::check($this->current_password, $this->customer->password)) {
            $this->addError('current_password', 'A senha atual está incorreta.');
            return;
        }

        $this->customer->update([
            'password' => Hash::make($this->password)
        ]);

        $this->reset(['current_password', 'password', 'password_confirmation']);
        $this->showPasswordForm = false;
        $this->dispatch('password-updated');
    }
    public function render()
    {
        return view('livewire.customer.profile.edit');
    }
}
