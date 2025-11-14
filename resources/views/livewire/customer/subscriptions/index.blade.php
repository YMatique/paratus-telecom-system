<div>
    {{-- Page Header --}}
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Minhas Subscrições</h1>
        <p class="mt-2 text-gray-600 dark:text-gray-400">
            Gerencie suas subscrições de internet e serviços
        </p>
    </div>

    {{-- Status Tabs --}}
    <div class="mb-6 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4">
        <div class="flex flex-wrap gap-2">
            <button 
                wire:click="filterByStatus('all')"
                class="px-4 py-2 rounded-lg text-sm font-medium transition
                    {{ $filterStatus === 'all' ? 'bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-300' : 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
                Todas ({{ $statusCounts['all'] }})
            </button>
            <button 
                wire:click="filterByStatus('active')"
                class="px-4 py-2 rounded-lg text-sm font-medium transition
                    {{ $filterStatus === 'active' ? 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300' : 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
                Ativas ({{ $statusCounts['active'] }})
            </button>
            <button 
                wire:click="filterByStatus('suspended')"
                class="px-4 py-2 rounded-lg text-sm font-medium transition
                    {{ $filterStatus === 'suspended' ? 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-300' : 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
                Suspensas ({{ $statusCounts['suspended'] }})
            </button>
            <button 
                wire:click="filterByStatus('cancelled')"
                class="px-4 py-2 rounded-lg text-sm font-medium transition
                    {{ $filterStatus === 'cancelled' ? 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300' : 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
                Canceladas ({{ $statusCounts['cancelled'] }})
            </button>
        </div>
    </div>

    {{-- Subscriptions Grid --}}
    @if($subscriptions->count() > 0)
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            @foreach($subscriptions as $subscription)
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-lg transition">
                    
                    {{-- Header --}}
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex items-start justify-between">
                            <div class="flex items-center gap-4">
                                {{-- Icon --}}
                                <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"/>
                                    </svg>
                                </div>
                                
                                {{-- Info --}}
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                                        {{ $subscription->plan->name }}
                                    </h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ $subscription->plan->download_speed }} MB/s Download
                                    </p>
                                </div>
                            </div>

                            {{-- Status Badge --}}
                            <span class="px-3 py-1 text-xs font-semibold rounded-full
                                @if($subscription->status === 'active') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                                @elseif($subscription->status === 'suspended') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300
                                @elseif($subscription->status === 'cancelled') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300
                                @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300
                                @endif">
                                @if($subscription->status === 'active') Ativa
                                @elseif($subscription->status === 'suspended') Suspensa
                                @elseif($subscription->status === 'cancelled') Cancelada
                                @else {{ ucfirst($subscription->status) }}
                                @endif
                            </span>
                        </div>
                    </div>

                    {{-- Body --}}
                    <div class="p-6 space-y-4">
                        
                        {{-- Velocidade --}}
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2 text-gray-600 dark:text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                                <span class="text-sm">Velocidade</span>
                            </div>
                            <span class="font-semibold text-gray-900 dark:text-white">
                                {{ $subscription->plan->download_speed }} / {{ $subscription->plan->upload_speed }} MB
                            </span>
                        </div>

                        {{-- Preço --}}
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2 text-gray-600 dark:text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="text-sm">Mensalidade</span>
                            </div>
                            <span class="font-semibold text-gray-900 dark:text-white">
                                {{ number_format($subscription->monthly_price, 2, ',', '.') }} MT/mês
                            </span>
                        </div>

                        {{-- Endereço --}}
                        <div class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-gray-600 dark:text-gray-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm text-gray-600 dark:text-gray-400">Endereço de Instalação</p>
                                <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                    {{ $subscription->installationAddress->city ?? 'N/A' }}, {{ $subscription->installationAddress->neighborhood ?? '' }}
                                </p>
                            </div>
                        </div>

                        {{-- Data de Início --}}
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-600 dark:text-gray-400">Cliente desde</span>
                            <span class="font-medium text-gray-900 dark:text-white">
                                {{ $subscription->start_date->format('d/m/Y') }}
                            </span>
                        </div>

                        {{-- Produtos (se houver) --}}
                        @if($subscription->subscriptionProducts->count() > 0)
                            <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Equipamentos:</p>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($subscription->subscriptionProducts->take(3) as $subProduct)
                                        <span class="px-2.5 py-1 text-xs font-medium bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300 rounded-full">
                                            {{ $subProduct->product->name }}
                                        </span>
                                    @endforeach
                                    @if($subscription->subscriptionProducts->count() > 3)
                                        <span class="px-2.5 py-1 text-xs font-medium bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300 rounded-full">
                                            +{{ $subscription->subscriptionProducts->count() - 3 }} mais
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- Footer Actions --}}
                    <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700/50 border-t border-gray-200 dark:border-gray-700">
                        <button 
                            wire:click="viewDetails({{ $subscription->id }})"
                            class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition flex items-center justify-center gap-2">
                            Ver Detalhes
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $subscriptions->links() }}
        </div>

    @else
        {{-- Empty State --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-12 text-center">
            <div class="w-20 h-20 mx-auto bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-4">
                <svg class="w-10 h-10 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"/>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                Nenhuma subscrição encontrada
            </h3>
            <p class="text-gray-600 dark:text-gray-400 mb-6">
                @if($filterStatus !== 'all')
                    Você não tem subscrições com o status "{{ $filterStatus }}".
                @else
                    Você ainda não possui subscrições ativas.
                @endif
            </p>
            @if($filterStatus !== 'all')
                <button 
                    wire:click="filterByStatus('all')"
                    class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    Ver Todas
                </button>
            @else
                <a href="{{ route('customer.plans.index') }}" 
                   wire:navigate
                   class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    Ver Planos Disponíveis
                </a>
            @endif
        </div>
    @endif

    {{-- Loading Indicator --}}
    <div wire:loading class="fixed inset-0 bg-black/20 flex items-center justify-center z-50">
        <div class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow-xl">
            <svg class="animate-spin h-8 w-8 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </div>
    </div>
</div>