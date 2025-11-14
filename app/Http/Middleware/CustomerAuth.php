<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CustomerAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
         // Verificar se está autenticado no guard 'customer'
        if (!Auth::guard('customer')->check()) {
            return redirect()->route('customer.login')
                ->with('error', 'Por favor, faça login para acessar o portal.');
        }

        $customer = Auth::guard('customer')->user();

        // Verificar se cliente está ativo
        if ($customer->status !== 'active') {
            Auth::guard('customer')->logout();
            
            return redirect()->route('customer.login')
                ->with('error', 'Sua conta está ' . $customer->status . '. Entre em contato com o suporte.');
        }

        // Atualizar última atividade
        $customer->touch('last_login_at');
        return $next($request);
    }
}
