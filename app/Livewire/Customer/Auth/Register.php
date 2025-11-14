<?php

namespace App\Livewire\Customer\Auth;
use App\Models\Customer;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
#[Layout('components.layouts.customer-auth')]
#[Title('Ativar Conta - Portal do Cliente')]
class Register extends Component
{
    #[Validate('required|string')]
    public string $document = '';

    #[Validate('required|email')]
    public string $email = '';

    #[Validate('required|string|min:8|confirmed')]
    public string $password = '';

    public string $password_confirmation = '';

    public bool $terms = false;

    /**
     * Ativar conta do cliente
     * Cliente já deve existir no sistema (cadastrado pelo admin)
     */
    public function register()
    {
        $this->validate([
            'document' => 'required|string',
            'email' => 'required|email',
            'password' => ['required', 'confirmed', Password::defaults()],
            'terms' => 'accepted',
        ]);

        // Buscar cliente existente
        $customer = Customer::where('document', $this->document)
            ->where('email', $this->email)
            ->whereNull('password') // Ainda não ativou conta
            ->first();

        if (!$customer) {
            $this->addError('document', 'Nenhum cliente encontrado com estes dados. Contacte o suporte.');
            return;
        }

        // Verificar status
        if ($customer->status !== 'active') {
            $this->addError('document', 'Sua conta está ' . $customer->status . '. Contacte o suporte.');
            return;
        }

        // Ativar acesso ao portal
        $customer->update([
            'password' => Hash::make($this->password),
            'email_verified_at' => now(), // Auto-verificar email
        ]);

        // Disparar evento
        event(new Registered($customer));

        // Login automático
        Auth::guard('customer')->login($customer);
        $customer->updateLastLogin();

        session()->flash('success', 'Bem-vindo! Sua conta foi ativada com sucesso.');

        return $this->redirect(route('customer.dashboard'), navigate: true);
    }
    public function render()
    {
        return view('livewire.customer.auth.register');
    }
}
