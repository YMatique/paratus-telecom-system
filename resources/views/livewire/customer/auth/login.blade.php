<div class="p-8">
    {{-- Header --}}
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Bem-vindo de volta!</h2>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
            Acesse seu portal para gerenciar suas subscrições
        </p>
    </div>

    {{-- Formulário --}}
    <form wire:submit="login" class="space-y-6">
        
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
                    autofocus
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
                    placeholder="••••••••"
                    required
                />
            </div>
            @error('password')
                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        {{-- Remember & Forgot Password --}}
        <div class="flex items-center justify-between">
            <label class="flex items-center">
                <input 
                    type="checkbox" 
                    wire:model="remember"
                    class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700"
                />
                <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Lembrar-me</span>
            </label>

            <a 
            {{-- href="{{ route('customer.password.request') }}"  --}}
               wire:navigate
               class="text-sm font-medium text-blue-600 hover:text-blue-500 dark:text-blue-400">
                Esqueceu a senha?
            </a>
        </div>

        {{-- Submit Button --}}
        <button 
            type="submit"
            wire:loading.attr="disabled"
            class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-blue-600 hover:bg-blue-700 
                   text-white font-medium rounded-lg transition duration-150
                   disabled:opacity-50 disabled:cursor-not-allowed
                   focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
            
            <span wire:loading.remove>Entrar</span>
            
            <span wire:loading class="flex items-center gap-2">
                <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Entrando...
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
                Primeira vez aqui?
            </span>
        </div>
    </div>

    {{-- Register Link --}}
    <div class="text-center">
        <p class="text-sm text-gray-600 dark:text-gray-400">
            Já é nosso cliente?
            <a href="{{ route('customer.register') }}" 
               wire:navigate
               class="font-medium text-blue-600 hover:text-blue-500 dark:text-blue-400">
                Ative sua conta aqui
            </a>
        </p>
    </div>

    {{-- Help --}}
    <div class="mt-8 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600">
        <div class="flex items-start gap-3">
            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <h4 class="text-sm font-medium text-gray-900 dark:text-white">Precisa de ajuda?</h4>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Entre em contato com nosso suporte pelo telefone 
                    <a href="tel:+258840000000" class="font-medium text-blue-600 hover:underline">
                        +258 84 000 0000
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>