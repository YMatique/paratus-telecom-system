<div class="p-8">
    {{-- Header --}}
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Ative sua conta</h2>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
            Já é nosso cliente? Crie sua senha para acessar o portal
        </p>
    </div>

    {{-- Info Alert --}}
    <div class="mb-6 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
        <div class="flex gap-3">
            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <h4 class="text-sm font-semibold text-blue-900 dark:text-blue-200">Como funciona?</h4>
                <p class="mt-1 text-sm text-blue-800 dark:text-blue-300">
                    Se você já é nosso cliente, use os dados cadastrados (Documento e Email) para ativar o acesso ao portal.
                </p>
            </div>
        </div>
    </div>

    {{-- Formulário --}}
    <form wire:submit="register" class="space-y-6">
        
        {{-- Documento (BI/NUIT) --}}
        <div>
            <label for="document" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                Número do Documento (BI ou NUIT)
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                    </svg>
                </div>
                <input 
                    type="text" 
                    id="document"
                    wire:model="document"
                    class="block w-full pl-10 pr-3 py-3 border border-gray-300 dark:border-gray-600 rounded-lg 
                           focus:ring-2 focus:ring-blue-500 focus:border-transparent
                           dark:bg-gray-700 dark:text-white
                           @error('document') border-red-500 @enderror"
                    placeholder="123456789"
                    autofocus
                    required
                />
            </div>
            @error('document')
                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        {{-- Email --}}
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                Email
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                    </svg>
                </div>
                <input 
                    type="email" 
                    id="email"
                    wire:model="email"
                    class="block w-full pl-10 pr-3 py-3 border border-gray-300 dark:border-gray-600 rounded-lg 
                           focus:ring-2 focus:ring-blue-500 focus:border-transparent
                           dark:bg-gray-700 dark:text-white
                           @error('email') border-red-500 @enderror"
                    placeholder="seu@email.com"
                    required
                />
            </div>
            @error('email')
                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        {{-- Password --}}
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                Senha
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <input 
                    type="password" 
                    id="password"
                    wire:model="password"
                    class="block w-full pl-10 pr-3 py-3 border border-gray-300 dark:border-gray-600 rounded-lg 
                           focus:ring-2 focus:ring-blue-500 focus:border-transparent
                           dark:bg-gray-700 dark:text-white
                           @error('password') border-red-500 @enderror"
                    placeholder="Mínimo 8 caracteres"
                    required
                />
            </div>
            @error('password')
                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @else
                <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                    Use no mínimo 8 caracteres com letras e números
                </p>
            @enderror
        </div>

        {{-- Confirm Password --}}
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                Confirmar Senha
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <input 
                    type="password" 
                    id="password_confirmation"
                    wire:model="password_confirmation"
                    class="block w-full pl-10 pr-3 py-3 border border-gray-300 dark:border-gray-600 rounded-lg 
                           focus:ring-2 focus:ring-blue-500 focus:border-transparent
                           dark:bg-gray-700 dark:text-white"
                    placeholder="Digite a senha novamente"
                    required
                />
            </div>
        </div>

        {{-- Terms --}}
        <div>
            <label class="flex items-start gap-3">
                <input 
                    type="checkbox" 
                    wire:model="terms"
                    class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 
                           dark:border-gray-600 dark:bg-gray-700 mt-1
                           @error('terms') border-red-500 @enderror"
                    required
                />
                <span class="text-sm text-gray-600 dark:text-gray-400">
                    Eu li e concordo com os 
                    <a href="#" class="font-medium text-blue-600 hover:underline dark:text-blue-400">Termos de Uso</a>
                    e 
                    <a href="#" class="font-medium text-blue-600 hover:underline dark:text-blue-400">Política de Privacidade</a>
                </span>
            </label>
            @error('terms')
                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        {{-- Submit Button --}}
        <button 
            type="submit"
            wire:loading.attr="disabled"
            class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-blue-600 hover:bg-blue-700 
                   text-white font-medium rounded-lg transition duration-150
                   disabled:opacity-50 disabled:cursor-not-allowed
                   focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
            
            <span wire:loading.remove>Ativar Conta</span>
            
            <span wire:loading class="flex items-center gap-2">
                <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Ativando...
            </span>
        </button>
    </form>

    {{-- Divider --}}
    <div class="relative my-8">
        <div class="absolute inset-0 flex items-center">
            <div class="w-full border-t border-gray-300 dark:border-gray-600"></div>
        </div>
        <div class="relative flex justify-center text-sm">
            <span class="px-4 bg-white dark:bg-gray-800 text-gray-500 dark:text-gray-400">
                Já tem conta?
            </span>
        </div>
    </div>

    {{-- Login Link --}}
    <div class="text-center">
        <p class="text-sm text-gray-600 dark:text-gray-400">
            <a href="{{ route('customer.login') }}" 
               wire:navigate
               class="font-medium text-blue-600 hover:text-blue-500 dark:text-blue-400">
                Fazer login
            </a>
        </p>
    </div>

    {{-- Help --}}
    <div class="mt-8 p-4 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg">
        <div class="flex items-start gap-3">
            <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
            <div>
                <h4 class="text-sm font-medium text-yellow-900 dark:text-yellow-200">Dados não encontrados?</h4>
                <p class="mt-1 text-sm text-yellow-800 dark:text-yellow-300">
                    Se não conseguir ativar sua conta, entre em contato com nosso suporte pelo telefone 
                    <a href="tel:+258840000000" class="font-semibold hover:underline">
                        +258 84 000 0000
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>