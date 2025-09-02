<?php

// app/Http/Controllers/Concerns/WithToast.php
namespace App\Http\Controllers\Concerns;

use Closure;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

trait WithToast
{
    /**
     * Flash a success toast to session
     */
    protected function toastSuccess(string $title, string $message = '', int $duration = 5000): void
    {
        session()->flash('toast', [
            'type' => 'success',
            'title' => $title,
            'message' => $message,
            'duration' => $duration,
        ]);
    }

    /**
     * Flash an error toast to session
     */
    protected function toastError(string $title, string $message = '', int $duration = 7000): void
    {
        session()->flash('toast', [
            'type' => 'error',
            'title' => $title,
            'message' => $message,
            'duration' => $duration,
        ]);
    }

    /**
     * Flash a warning toast to session
     */
    protected function toastWarning(string $title, string $message = '', int $duration = 6000): void
    {
        session()->flash('toast', [
            'type' => 'warning',
            'title' => $title,
            'message' => $message,
            'duration' => $duration,
        ]);
    }

    /**
     * Flash an info toast to session
     */
    protected function toastInfo(string $title, string $message = '', int $duration = 5000): void
    {
        session()->flash('toast', [
            'type' => 'info',
            'title' => $title,
            'message' => $message,
            'duration' => $duration,
        ]);
    }
}

// helpers.php - adicionar ao composer.json autoload.files
if (!function_exists('toast')) {
    /**
     * Helper global para toast notifications
     */
    function toast(string $type = 'success', string $title = '', string $message = '', int $duration = 5000): void
    {
        session()->flash('toast', [
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'duration' => $duration,
        ]);
    }
}

if (!function_exists('toast_success')) {
    function toast_success(string $title, string $message = '', int $duration = 5000): void
    {
        toast('success', $title, $message, $duration);
    }
}

if (!function_exists('toast_error')) {
    function toast_error(string $title, string $message = '', int $duration = 7000): void
    {
        toast('error', $title, $message, $duration);
    }
}

if (!function_exists('toast_warning')) {
    function toast_warning(string $title, string $message = '', int $duration = 6000): void
    {
        toast('warning', $title, $message, $duration);
    }
}

if (!function_calls('toast_info')) {
    function toast_info(string $title, string $message = '', int $duration = 5000): void
    {
        toast('info', $title, $message, $duration);
    }
}

// Exemplos de uso em Request/FormRequest
class StoreCustomerRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        // Lógica de preparação
    }
    
    protected function passedValidation()
    {
        toast_success('Dados válidos!', 'Cliente pode ser cadastrado.');
    }
    
    protected function failedValidation(Validator $validator)
    {
        toast_error('Erro de validação!', 'Verifique os dados informados.');
        parent::failedValidation($validator);
    }
}

// Middleware para toasts automáticos
class ToastMiddleware
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        // Toast automático para operações CRUD
        if ($request->isMethod('POST') && $response->isRedirect()) {
            $routeName = $request->route()->getName();
            
            if (str_contains($routeName, '.store')) {
                toast_success('Criado com sucesso!');
            } elseif (str_contains($routeName, '.update')) {
                toast_success('Atualizado com sucesso!');
            } elseif (str_contains($routeName, '.destroy')) {
                toast_success('Removido com sucesso!');
            }
        }

        return $response;
    }
}