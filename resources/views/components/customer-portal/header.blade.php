@php
    $customer = Auth::guard('customer')->user();
@endphp

<header class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700 sticky top-0 z-40">
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            
            {{-- Logo + Mobile Menu Toggle --}}
            <div class="flex items-center gap-4">
                {{-- Mobile Menu Button --}}
                <button @click="sidebarOpen = !sidebarOpen" 
                        class="lg:hidden p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                    <svg class="w-6 h-6 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>

                {{-- Logo --}}
                <a href="{{ route('customer.dashboard') }}" class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"/>
                        </svg>
                    </div>
                    <span class="hidden sm:block text-xl font-bold text-gray-900 dark:text-white">Portal</span>
                </a>
            </div>

            {{-- Right Side: Notifications + Profile --}}
            <div class="flex items-center gap-3">
                
                {{-- Notifications --}}
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" 
                            class="relative p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                        <svg class="w-6 h-6 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        {{-- Badge de notificações --}}
                        <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                    </button>

                    {{-- Dropdown de Notificações --}}
                    <div x-show="open" 
                         @click.away="open = false"
                         x-transition
                         class="absolute right-0 mt-2 w-80 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                        
                        <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="font-semibold text-gray-900 dark:text-white">Notificações</h3>
                        </div>

                        <div class="max-h-96 overflow-y-auto">
                            {{-- Exemplo de notificação --}}
                            <a href="#" class="block p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                <div class="flex gap-3">
                                    <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center flex-shrink-0">
                                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">Nova fatura disponível</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Fatura #001/2024 - MT 1.200,00</p>
                                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Há 2 horas</p>
                                    </div>
                                </div>
                            </a>

                            {{-- Mensagem vazia --}}
                            <div class="p-8 text-center text-gray-500 dark:text-gray-400">
                                <svg class="w-12 h-12 mx-auto mb-3 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                </svg>
                                <p class="text-sm">Nenhuma notificação</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- User Menu --}}
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" 
                            class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                        <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                            <span class="text-white font-semibold text-sm">{{ strtoupper(substr($customer->name, 0, 2)) }}</span>
                        </div>
                        <div class="hidden md:block text-left">
                            <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $customer->name }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $customer->email }}</p>
                        </div>
                        <svg class="w-4 h-4 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    {{-- Dropdown Menu --}}
                    <div x-show="open" 
                         @click.away="open = false"
                         x-transition
                         class="absolute right-0 mt-2 w-56 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                        
                        <div class="p-3 border-b border-gray-200 dark:border-gray-700">
                            <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $customer->name }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $customer->email }}</p>
                        </div>

                        <div class="p-2">
                            <a href="{{ route('customer.profile.edit') }}" 
                               class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                                <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                <span class="text-sm text-gray-700 dark:text-gray-300">Meu Perfil</span>
                            </a>

                            <a href="{{ route('customer.subscriptions.index') }}" 
                               class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                                <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"/>
                                </svg>
                                <span class="text-sm text-gray-700 dark:text-gray-300">Minhas Subscrições</span>
                            </a>
                        </div>

                        <div class="p-2 border-t border-gray-200 dark:border-gray-700">
                            <form method="POST" action="{{ route('customer.logout') }}">
                                @csrf
                                <button type="submit" 
                                        class="w-full flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20 transition text-red-600 dark:text-red-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                    </svg>
                                    <span class="text-sm font-medium">Sair</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>