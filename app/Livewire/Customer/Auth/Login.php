<?php

namespace App\Livewire\Customer\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout('livewire.layouts.customer-auth')]
#[Title('Login - Portal do Cliente')]
class Login extends Component
{
    #[Validate('required|email')]
    public string $email = '';

    #[Validate('required')]
    public string $password = '';

    public bool $remember = false;

    /**
     * Autenticar cliente
     */
    public function login()
    {
        $this->validate();

        $this->ensureIsNotRateLimited();

        // Tentar autenticar no guard 'customer'
        if (!Auth::guard('customer')->attempt(
            ['email' => $this->email, 'password' => $this->password],
            $this->remember
        )) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => 'Credenciais incorretas.',
            ]);
        }

        RateLimiter::clear($this->throttleKey());

        // Atualizar último login
        $customer = Auth::guard('customer')->user();
        $customer->updateLastLogin();

        session()->regenerate();

        // Redirecionar para dashboard
        return $this->redirect(route('customer.dashboard'), navigate: true);
    }

    /**
     * Rate limiting
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => "Muitas tentativas. Tente novamente em {$seconds} segundos.",
        ]);
    }

    /**
     * Throttle key
     */
    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email) . '|' . request()->ip());
    }

    public function render()
    {
        return view('livewire.customer.auth.login');
    }
}
