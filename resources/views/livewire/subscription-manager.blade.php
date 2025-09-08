<div class="space-y-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Gestão de Subscrições</h1>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                Gerencie contratos, planos e ciclo de vida das subscrições
            </p>
        </div>

        @if ($activeTab === 'list')
            <button wire:click="createSubscription"
                class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Nova Subscrição
            </button>
        @endif
    </div>

    {{-- Stats Cards --}}
    @if ($activeTab === 'list')
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
            {{-- Ativas --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 border border-gray-200 dark:border-gray-700">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 dark:bg-green-900/20">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Ativas</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total_active'] }}</p>
                    </div>
                </div>
            </div>

            {{-- Suspensas --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 border border-gray-200 dark:border-gray-700">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-red-100 dark:bg-red-900/20">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Suspensas</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total_suspended'] }}</p>
                    </div>
                </div>
            </div>

            {{-- Pendentes --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 border border-gray-200 dark:border-gray-700">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 dark:bg-yellow-900/20">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Pend. Instalação</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['pending_installation'] }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- MRR --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 border border-gray-200 dark:border-gray-700">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900/20">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1">
                            </path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">MRR</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">
                            {{ number_format($stats['mrr'], 0, ',', '.') }} MT</p>
                    </div>
                </div>
            </div>

            {{-- Vencimento Próximo --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 border border-gray-200 dark:border-gray-700">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-orange-100 dark:bg-orange-900/20">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z">
                            </path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Vencem em 7 dias</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['due_soon'] }}</p>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Content Area --}}
    @if ($activeTab === 'list')
        {{-- Filtros e Busca --}}
        <div class="bg-white dark:bg-gray-800 rounded-lg p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex flex-col lg:flex-row gap-4">
                {{-- Busca --}}
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Buscar</label>
                    <input type="text" wire:model.live="search" placeholder="Nome do cliente, documento, plano..."
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                </div>

                {{-- Filtro Status --}}
                <div class="w-full lg:w-48">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                    <select wire:model.live="filterStatus"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        <option value="all">Todos</option>
                        <option value="active">Ativas</option>
                        <option value="suspended">Suspensas</option>
                        <option value="cancelled">Canceladas</option>
                        <option value="pending_installation">Pend. Instalação</option>
                    </select>
                </div>

                {{-- Filtro Plano --}}
                <div class="w-full lg:w-48">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Plano</label>
                    <select wire:model.live="filterPlan"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        <option value="all">Todos</option>
                        @foreach ($plans as $plan)
                            <option value="{{ $plan->id }}">{{ $plan->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Filtro Vencimento --}}
                <div class="w-full lg:w-48">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Vencimento</label>
                    <select wire:model.live="filterDueDate"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        <option value="all">Todos</option>
                        <option value="due_soon">Próximos 7 dias</option>
                        <option value="overdue">Em atraso</option>
                    </select>
                </div>
            </div>

            {{-- Bulk Actions --}}
            @if (count($selectedSubscriptions) > 0)
                <div class="flex items-center justify-between mt-4 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                    <span class="text-sm text-blue-800 dark:text-blue-200">
                        {{ count($selectedSubscriptions) }} subscrição(ões) selecionada(s)
                    </span>
                    <div class="flex items-center space-x-4">
                        <select wire:model="bulkAction"
                            class="px-3 py-1 border border-blue-300 dark:border-blue-600 rounded text-sm bg-white dark:bg-gray-700">
                            <option value="">Selecione ação</option>
                            <option value="suspend">Suspender</option>
                            <option value="reactivate">Reativar</option>
                        </select>
                        <button wire:click="executeBulkAction"
                            class="px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded transition-colors">
                            Executar
                        </button>
                    </div>
                </div>
            @endif
        </div>

        {{-- Tabela de Subscrições --}}
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3">
                                <input type="checkbox"
                                    class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Cliente
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Plano
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Status
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Valor Mensal
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Próximo Vencimento
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Data Início
                            </th>
                            <th
                                class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Ações
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($subscriptions as $subscription)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-6 py-4">
                                    <input type="checkbox" wire:model="selectedSubscriptions"
                                        value="{{ $subscription->id }}"
                                        class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div>
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $subscription->customer->name }}
                                            </div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                {{ $subscription->customer->document }} •
                                                {{ ucfirst($subscription->customer->type) }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $subscription->plan->name }}
                                    </div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $subscription->plan->download_speed }}/{{ $subscription->plan->upload_speed }}
                                        Mbps
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $statusConfig = [
                                            'active' => [
                                                'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400',
                                                'Ativa',
                                            ],
                                            'suspended' => [
                                                'bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400',
                                                'Suspensa',
                                            ],
                                            'cancelled' => [
                                                'bg-gray-100 text-gray-800 dark:bg-gray-900/20 dark:text-gray-400',
                                                'Cancelada',
                                            ],
                                            'pending_installation' => [
                                                'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400',
                                                'Pend. Instalação',
                                            ],
                                        ][$subscription->status];
                                    @endphp
                                    <span
                                        class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $statusConfig[0] }}">
                                        {{ $statusConfig[1] }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">
                                    {{ number_format($subscription->monthly_price, 2, ',', '.') }} MT
                                </td>
                                <td class="px-6 py-4">
                                    @if ($subscription->next_invoice_date)
                                        <div class="text-sm text-gray-900 dark:text-white">
                                            {{ $subscription->next_invoice_date->format('d/m/Y') }}
                                        </div>
                                        @php
                                            $daysUntilDue = now()->diffInDays($subscription->next_invoice_date, false);
                                        @endphp
                                        @if ($daysUntilDue < 0)
                                            <div class="text-xs text-red-600">{{ intval(abs($daysUntilDue)) }} dias em atraso
                                            </div>
                                        @elseif($daysUntilDue <= 7)
                                            <div class="text-xs text-yellow-600">{{ intval($daysUntilDue) }} dias</div>
                                        @else
                                            <div class="text-xs text-gray-500">{{ intval($daysUntilDue) }} dias</div>
                                        @endif
                                    @else
                                        <span class="text-sm text-gray-500">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">
                                    {{ $subscription->start_date->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 text-right text-sm font-medium">
                                    <div class="flex items-center justify-end space-x-2">
                                        {{-- Visualizar --}}
                                        <button wire:click="viewSubscription({{ $subscription->id }})"
                                            class="text-blue-600 hover:text-blue-900 dark:text-blue-400">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                </path>
                                            </svg>
                                        </button>

                                        {{-- Editar --}}
                                        <button wire:click="editSubscription({{ $subscription->id }})"
                                            class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                </path>
                                            </svg>
                                        </button>

                                        {{-- Ações por Status --}}
                                        @if ($subscription->status === 'active')
                                            <button wire:click="suspendSubscription({{ $subscription->id }})"
                                                class="text-red-600 hover:text-red-900 dark:text-red-400"
                                                title="Suspender">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            </button>
                                        @elseif($subscription->status === 'suspended')
                                            <button wire:click="reactivateSubscription({{ $subscription->id }})"
                                                class="text-green-600 hover:text-green-900 dark:text-green-400"
                                                title="Reativar">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                                    </path>
                                                </svg>
                                            </button>
                                        @endif

                                        {{-- Menu Dropdown --}}
                                        <div class="relative" x-data="{ open: false }">
                                            <button @click="open = !open"
                                                class="text-gray-400 hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-300">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path
                                                        d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z">
                                                    </path>
                                                </svg>
                                            </button>
                                            <div x-show="open" @click.away="open = false"
                                                class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg border border-gray-200 dark:border-gray-600 z-10">
                                                <div class="py-1">
                                                    <a href="#"
                                                        class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                                        Alterar Plano
                                                    </a>
                                                    <a href="#"
                                                        class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                                        Gerar Fatura
                                                    </a>
                                                    <a href="#"
                                                        class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                                        Abrir Ticket
                                                    </a>
                                                    @if ($subscription->canBeCancelled())
                                                        <hr class="border-gray-200 dark:border-gray-600">
                                                        <button
                                                            wire:click="cancelSubscription({{ $subscription->id }})"
                                                            class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100 dark:hover:bg-gray-700">
                                                            Cancelar Subscrição
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center">
                                    <div class="text-gray-500 dark:text-gray-400">
                                        <svg class="w-12 h-12 mx-auto mb-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                            </path>
                                        </svg>
                                        <h3 class="text-lg font-medium mb-2">Nenhuma subscrição encontrada</h3>
                                        <p class="text-sm mb-4">Comece criando uma nova subscrição para um cliente</p>
                                        <button wire:click="createSubscription"
                                            class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 4v16m8-8H4"></path>
                                            </svg>
                                            Criar Primeira Subscrição
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Paginação --}}
            @if ($subscriptions->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                    {{ $subscriptions->links() }}
                </div>
            @endif
        </div>
    @elseif($activeTab === 'create')
        {{-- Wizard de Criação --}}
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
            {{-- Header do Wizard --}}
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Nova Subscrição</h3>
                    <button wire:click="goToList"
                        class="text-gray-400 hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                {{-- Progress Steps --}}
                <div class="mt-4">
                    <div class="flex items-center">
                        @for ($i = 1; $i <= 3; $i++)
                            <div class="flex items-center {{ $i < 3 ? 'flex-1' : '' }}">
                                <div
                                    class="flex items-center justify-center w-8 h-8 rounded-full {{ $wizardStep >= $i ? 'bg-blue-600 text-white' : 'bg-gray-300 text-gray-600' }}">
                                    {{ $i }}
                                </div>
                                <div
                                    class="ml-2 text-sm {{ $wizardStep >= $i ? 'text-blue-600 font-medium' : 'text-gray-500' }}">
                                    @if ($i == 1)
                                        Selecionar Cliente
                                    @elseif($i == 2)
                                        Escolher Plano
                                    @else
                                        Configurações
                                    @endif
                                </div>
                                @if ($i < 3)
                                    <div
                                        class="flex-1 h-1 mx-4 {{ $wizardStep > $i ? 'bg-blue-600' : 'bg-gray-300' }} rounded">
                                    </div>
                                @endif
                            </div>
                        @endfor
                    </div>
                </div>
            </div>

            {{-- Step Content --}}
            <div class="p-6">
                @if ($wizardStep == 1)
                    {{-- Step 1: Selecionar Cliente --}}
                    <div class="space-y-6">
                        <div>
                            <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Selecionar Cliente</h4>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Cliente
                                        *</label>
                                    <select wire:model="customer_id"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white @error('customer_id') border-red-500 @enderror">
                                        <option value="">Selecione um cliente</option>
                                        @foreach ($customers as $customer)
                                            <option value="{{ $customer->id }}">
                                                {{ $customer->name }} - {{ $customer->document }}
                                                ({{ ucfirst($customer->type) }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('customer_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            @if ($selectedCustomer)
                                <div class="mt-4 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                                    <h5 class="font-medium text-blue-900 dark:text-blue-300">Cliente Selecionado</h5>
                                    <div class="mt-2 text-sm text-blue-800 dark:text-blue-400">
                                        <p><strong>Nome:</strong> {{ $selectedCustomer->name }}</p>
                                        <p><strong>Documento:</strong> {{ $selectedCustomer->document }}</p>
                                        <p><strong>Tipo:</strong> {{ ucfirst($selectedCustomer->type) }}</p>
                                        @if ($selectedCustomer->email)
                                            <p><strong>Email:</strong> {{ $selectedCustomer->email }}</p>
                                        @endif
                                        @if ($selectedCustomer->phone)
                                            <p><strong>Telefone:</strong> {{ $selectedCustomer->phone }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @elseif($wizardStep == 2)
                    {{-- Step 2: Escolher Plano e Endereço --}}
                    <div class="space-y-6">
                        <div>
                            <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Escolher Plano e
                                Endereço</h4>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                {{-- Plano --}}
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Plano
                                        *</label>
                                    <select wire:model="plan_id"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white @error('plan_id') border-red-500 @enderror">
                                        <option value="">Selecione um plano</option>
                                        @foreach ($plans as $plan)
                                            <option value="{{ $plan->id }}">
                                                {{ $plan->name }} -
                                                {{ $plan->download_speed }}/{{ $plan->upload_speed }}Mbps -
                                                {{ number_format($plan->price, 0, ',', '.') }} MT
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('plan_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Endereço de Instalação --}}
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Endereço
                                        de Instalação *</label>
                                    <select wire:model="installation_address_id"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white @error('installation_address_id') border-red-500 @enderror">
                                        <option value="">Selecione um endereço</option>
                                        @foreach ($addresses as $address)
                                            <option value="{{ $address->id }}">
                                                {{ ucfirst($address->type) }}: {{ $address->street }},
                                                {{ $address->neighborhood }} - {{ $address->city }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('installation_address_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror

                                    @if (count($addresses) == 0)
                                        <p class="mt-2 text-sm text-yellow-600">
                                            ⚠️ Este cliente não possui endereços cadastrados.
                                            <button class="text-blue-600 underline">Criar novo endereço</button>
                                        </p>
                                    @endif
                                </div>
                            </div>

                            {{-- Preview do Plano Selecionado --}}
                            @if ($selectedPlan)
                                <div class="mt-4 p-4 bg-green-50 dark:bg-green-900/20 rounded-lg">
                                    <h5 class="font-medium text-green-900 dark:text-green-300">Plano Selecionado</h5>
                                    <div class="mt-2 text-sm text-green-800 dark:text-green-400">
                                        <p><strong>{{ $selectedPlan->name }}</strong></p>
                                        <p>Velocidade:
                                            {{ $selectedPlan->download_speed }}/{{ $selectedPlan->upload_speed }} Mbps
                                        </p>
                                        <p>Preço: {{ number_format($selectedPlan->price, 2, ',', '.') }} MT/mês</p>
                                        @if ($selectedPlan->description)
                                            <p>{{ $selectedPlan->description }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @elseif($wizardStep == 3)
                    {{-- Step 3: Configurações Finais --}}
                    <div class="space-y-6">
                        <div>
                            <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Configurações da
                                Subscrição</h4>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                {{-- Data de Início --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Data
                                        de Início *</label>
                                    <input type="date" wire:model="start_date"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white @error('start_date') border-red-500 @enderror">
                                    @error('start_date')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Status --}}
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status
                                        Inicial *</label>
                                    <select wire:model="status"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white @error('status') border-red-500 @enderror">
                                        <option value="pending_installation">Pendente Instalação</option>
                                        <option value="active">Ativa</option>
                                    </select>
                                    @error('status')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Preço Mensal --}}
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Preço
                                        Mensal (MT) *</label>
                                    <input type="number" wire:model="monthly_price" step="0.01" min="0"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white @error('monthly_price') border-red-500 @enderror">
                                    @error('monthly_price')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-1 text-xs text-gray-500">Será usado este valor para faturamento</p>
                                </div>

                                {{-- Taxa de Instalação --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Taxa
                                        de Instalação (MT)</label>
                                    <input type="number" wire:model="installation_fee" step="0.01"
                                        min="0"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white @error('installation_fee') border-red-500 @enderror">
                                    @error('installation_fee')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Dia de Vencimento --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Dia
                                        do Vencimento *</label>
                                    <select wire:model="billing_day"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white @error('billing_day') border-red-500 @enderror">
                                        @for ($day = 1; $day <= 28; $day++)
                                            <option value="{{ $day }}">Dia {{ $day }}</option>
                                        @endfor
                                    </select>
                                    @error('billing_day')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Auto Renovação --}}
                                <div>
                                    <div class="flex items-center">
                                        <input type="checkbox" wire:model="auto_renew"
                                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <label class="ml-2 block text-sm text-gray-900 dark:text-white">
                                            Renovação Automática
                                        </label>
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500">A subscrição será renovada automaticamente
                                        todo mês</p>
                                </div>
                            </div>

                            {{-- Observações --}}
                            <div class="mt-6">
                                <label
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Observações</label>
                                <textarea wire:model="notes" rows="3" placeholder="Observações sobre esta subscrição..."
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white @error('notes') border-red-500 @enderror"></textarea>
                                @error('notes')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Resumo Final --}}
                            <div class="mt-6 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <h5 class="font-medium text-gray-900 dark:text-white mb-3">Resumo da Subscrição</h5>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                    <div>
                                        <p><strong>Cliente:</strong> {{ $selectedCustomer->name ?? '' }}</p>
                                        <p><strong>Plano:</strong> {{ $selectedPlan->name ?? '' }}</p>
                                        <p><strong>Velocidade:</strong>
                                            {{ $selectedPlan->download_speed ?? '' }}/{{ $selectedPlan->upload_speed ?? '' }}
                                            Mbps</p>
                                        <p><strong>Data Início:</strong>
                                            {{ $start_date ? \Carbon\Carbon::parse($start_date)->format('d/m/Y') : '' }}
                                        </p>
                                    </div>
                                    <div>
                                        <p><strong>Status:</strong> {{ ucfirst(str_replace('_', ' ', $status)) }}</p>
                                        <p><strong>Valor Mensal:</strong>
                                            {{ number_format((float)$monthly_price, 2, ',', '.') }} MT</p>
                                        <p><strong>Taxa Instalação:</strong>
                                            {{ number_format((float)$installation_fee, 2, ',', '.') }} MT</p>
                                        <p><strong>Dia Vencimento:</strong> {{ $billing_day }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Wizard Actions --}}
            <div
                class="px-6 py-4 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600 flex items-center justify-between">
                <div>
                    @if ($wizardStep > 1)
                        <button wire:click="previousStep"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7"></path>
                            </svg>
                            Anterior
                        </button>
                    @endif
                </div>

                <div>
                    @if ($wizardStep < 3)
                        <button wire:click="nextStep"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md transition-colors">
                            Próximo
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>
                    @else
                        <button wire:click="saveSubscription"
                            class="inline-flex items-center px-6 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-md transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                            Criar Subscrição
                        </button>
                    @endif
                </div>
            </div>
        </div>
    @elseif($activeTab === 'view')
        {{-- Visualização Detalhada --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Informações Principais --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- Cabeçalho --}}
                <div class="bg-white dark:bg-gray-800 rounded-lg p-6 border border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-4">
                            <button wire:click="goToList"
                                class="text-gray-400 hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 19l-7-7 7-7"></path>
                                </svg>
                            </button>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                                    Subscrição #{{ $selectedSubscription->id ?? '' }}
                                </h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    Criada em
                                    {{ $selectedSubscription->created_at ? $selectedSubscription->created_at->format('d/m/Y') : '' }}
                                </p>
                            </div>
                        </div>

                        <button wire:click="editSubscription({{ $selectedSubscription->id ?? '' }})"
                            class="inline-flex items-center px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                </path>
                            </svg>
                            Editar
                        </button>
                    </div>

                    {{-- Status e Info Rápida --}}
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Status</label>
                            @if ($selectedSubscription)
                                @php
                                    $statusConfig = [
                                        'active' => [
                                            'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400',
                                            'Ativa',
                                        ],
                                        'suspended' => [
                                            'bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400',
                                            'Suspensa',
                                        ],
                                        'cancelled' => [
                                            'bg-gray-100 text-gray-800 dark:bg-gray-900/20 dark:text-gray-400',
                                            'Cancelada',
                                        ],
                                        'pending_installation' => [
                                            'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400',
                                            'Pend. Instalação',
                                        ],
                                    ][$selectedSubscription->status];
                                @endphp
                                <span
                                    class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $statusConfig[0] }}">
                                    {{ $statusConfig[1] }}
                                </span>
                            @endif
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Valor
                                Mensal</label>
                            <p class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ number_format($selectedSubscription->monthly_price ?? 0, 2, ',', '.') }} MT
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Próximo
                                Vencimento</label>
                            <p class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ $selectedSubscription->next_invoice_date ? $selectedSubscription->next_invoice_date->format('d/m/Y') : '-' }}
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Data
                                Início</label>
                            <p class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ $selectedSubscription->start_date ? $selectedSubscription->start_date->format('d/m/Y') : '-' }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Detalhes do Cliente e Plano --}}
                <div class="bg-white dark:bg-gray-800 rounded-lg p-6 border border-gray-200 dark:border-gray-700">
                    <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Detalhes</h4>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Cliente --}}
                        <div>
                            <h5 class="font-medium text-gray-900 dark:text-white mb-3">Cliente</h5>
                            <div class="space-y-2 text-sm">
                                <p><strong>Nome:</strong> {{ $selectedSubscription->customer->name ?? '' }}</p>
                                <p><strong>Documento:</strong> {{ $selectedSubscription->customer->document ?? '' }}
                                </p>
                                <p><strong>Tipo:</strong> {{ ucfirst($selectedSubscription->customer->type ?? '') }}
                                </p>
                                @if ($selectedSubscription->customer->email ?? '')
                                    <p><strong>Email:</strong> {{ $selectedSubscription->customer->email }}</p>
                                @endif
                                @if ($selectedSubscription->customer->phone ?? '')
                                    <p><strong>Telefone:</strong> {{ $selectedSubscription->customer->phone }}</p>
                                @endif
                            </div>
                        </div>

                        {{-- Plano --}}
                        <div>
                            <h5 class="font-medium text-gray-900 dark:text-white mb-3">Plano</h5>
                            <div class="space-y-2 text-sm">
                                <p><strong>Nome:</strong> {{ $selectedSubscription->plan->name ?? '' }}</p>
                                <p><strong>Velocidade:</strong>
                                    {{ $selectedSubscription->plan->download_speed ?? '' }}/{{ $selectedSubscription->plan->upload_speed ?? '' }}
                                    Mbps</p>
                                <p><strong>Tipo:</strong>
                                    {{ ucfirst($selectedSubscription->plan->connection_type ?? '') }}</p>
                                <p><strong>Preço Original:</strong>
                                    {{ number_format($selectedSubscription->plan->price ?? 0, 2, ',', '.') }} MT</p>
                                <p><strong>Preço Contratado:</strong>
                                    {{ number_format($selectedSubscription->monthly_price ?? 0, 2, ',', '.') }} MT</p>
                            </div>
                        </div>
                    </div>

                    {{-- Endereço de Instalação --}}
                    @if ($selectedSubscription->installationAddress ?? '')
                        <div class="mt-6">
                            <h5 class="font-medium text-gray-900 dark:text-white mb-3">Endereço de Instalação</h5>
                            <div class="text-sm">
                                <p>{{ $selectedSubscription->installationAddress->full_address }}</p>
                                @if ($selectedSubscription->installationAddress->reference)
                                    <p class="text-gray-600 dark:text-gray-400">Referência:
                                        {{ $selectedSubscription->installationAddress->reference }}</p>
                                @endif
                            </div>
                        </div>
                    @endif

                    {{-- Observações --}}
                    @if ($selectedSubscription->notes ?? '')
                        <div class="mt-6">
                            <h5 class="font-medium text-gray-900 dark:text-white mb-3">Observações</h5>
                            <div class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-line">
                                {{ $selectedSubscription->notes }}
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Histórico de Faturas --}}
                <div class="bg-white dark:bg-gray-800 rounded-lg p-6 border border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-lg font-medium text-gray-900 dark:text-white">Últimas Faturas</h4>
                        <button class="text-blue-600 hover:text-blue-800 text-sm font-medium">Ver Todas</button>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead>
                                <tr class="border-b border-gray-200 dark:border-gray-600">
                                    <th class="text-left py-2 text-sm font-medium text-gray-500 dark:text-gray-400">
                                        Número</th>
                                    <th class="text-left py-2 text-sm font-medium text-gray-500 dark:text-gray-400">
                                        Data</th>
                                    <th class="text-left py-2 text-sm font-medium text-gray-500 dark:text-gray-400">
                                        Valor</th>
                                    <th class="text-left py-2 text-sm font-medium text-gray-500 dark:text-gray-400">
                                        Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($selectedSubscription->invoices ?? [] as $invoice)
                                    <tr class="border-b border-gray-100 dark:border-gray-700">
                                        <td class="py-2 text-sm text-gray-900 dark:text-white">
                                            #{{ $invoice->invoice_number }}</td>
                                        <td class="py-2 text-sm text-gray-600 dark:text-gray-400">
                                            {{ $invoice->issue_date->format('d/m/Y') }}</td>
                                        <td class="py-2 text-sm text-gray-900 dark:text-white">
                                            {{ number_format($invoice->total_amount, 2, ',', '.') }} MT</td>
                                        <td class="py-2">
                                            <span
                                                class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $invoice->isPaid() ? 'bg-green-100 text-green-800' : ($invoice->isOverdue() ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                                {{ $invoice->isPaid() ? 'Paga' : ($invoice->isOverdue() ? 'Vencida' : 'Pendente') }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4"
                                            class="py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                            Nenhuma fatura encontrada
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Sidebar de Ações --}}
            <div class="space-y-6">
                {{-- Ações Rápidas --}}
                <div class="bg-white dark:bg-gray-800 rounded-lg p-6 border border-gray-200 dark:border-gray-700">
                    <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Ações</h4>
                    <div class="space-y-3">
                        @if ($selectedSubscription && $selectedSubscription->status === 'active')
                            <button wire:click="suspendSubscription({{ $selectedSubscription->id }})"
                                class="w-full flex items-center justify-center px-3 py-2 border border-red-300 dark:border-red-600 text-sm font-medium rounded-md text-red-700 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Suspender
                            </button>
                        @elseif($selectedSubscription && $selectedSubscription->status === 'suspended')
                            <button wire:click="reactivateSubscription({{ $selectedSubscription->id }})"
                                class="w-full flex items-center justify-center px-3 py-2 border border-green-300 dark:border-green-600 text-sm font-medium rounded-md text-green-700 dark:text-green-400 hover:bg-green-50 dark:hover:bg-green-900/20">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                    </path>
                                </svg>
                                Reativar
                            </button>
                        @endif

                        <button
                            class="w-full flex items-center justify-center px-3 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                            Gerar Fatura
                        </button>

                        <button
                            class="w-full flex items-center justify-center px-3 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 8h10m0 0V6a2 2 0 00-2-2H9a2 2 0 00-2 2v2m10 0v10a2 2 0 01-2 2H9a2 2 0 01-2-2V8m10 0H7m3 5l2-2m0 0l2 2m-2-2v6">
                                </path>
                            </svg>
                            Alterar Plano
                        </button>

                        <button
                            class="w-full flex items-center justify-center px-3 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
                                </path>
                            </svg>
                            Abrir Ticket
                        </button>

                        @if ($selectedSubscription && $selectedSubscription->canBeCancelled())
                            <hr class="border-gray-200 dark:border-gray-600">
                            <button wire:click="cancelSubscription({{ $selectedSubscription->id }})"
                                class="w-full flex items-center justify-center px-3 py-2 border border-red-300 dark:border-red-600 text-sm font-medium rounded-md text-red-700 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                    </path>
                                </svg>
                                Cancelar Subscrição
                            </button>
                        @endif
                    </div>
                </div>

                {{-- Informações Adicionais --}}
                <div class="bg-white dark:bg-gray-800 rounded-lg p-6 border border-gray-200 dark:border-gray-700">
                    <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Resumo</h4>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500 dark:text-gray-400">Total Faturas:</span>
                            <span
                                class="font-medium text-gray-900 dark:text-white">{{ $selectedSubscription->invoices->count() ?? 0 }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500 dark:text-gray-400">Tickets Abertos:</span>
                            <span
                                class="font-medium text-gray-900 dark:text-white">{{ $selectedSubscription->tickets->where('status', '!=', 'closed')->count() ?? 0 }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500 dark:text-gray-400">Equipamentos:</span>
                            <span
                                class="font-medium text-gray-900 dark:text-white">{{ $selectedSubscription->getEquipment()->count() ?? 0 }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500 dark:text-gray-400">Auto Renovação:</span>
                            <span
                                class="font-medium {{ $selectedSubscription->auto_renew ? 'text-green-600' : 'text-red-600' }}">
                                {{ $selectedSubscription->auto_renew ? 'Ativa' : 'Inativa' }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Últimos Tickets --}}
                @if ($selectedSubscription->tickets && $selectedSubscription->tickets->count() > 0)
                    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 border border-gray-200 dark:border-gray-700">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-lg font-medium text-gray-900 dark:text-white">Últimos Tickets</h4>
                            <button class="text-blue-600 hover:text-blue-800 text-sm font-medium">Ver Todos</button>
                        </div>

                        <div class="space-y-3">
                            @foreach ($selectedSubscription->tickets->take(3) as $ticket)
                                <div class="flex items-start space-x-3 p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <div class="flex-shrink-0">
                                        <div
                                            class="w-8 h-8 bg-blue-100 dark:bg-blue-900/20 rounded-full flex items-center justify-center">
                                            <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
                                                </path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between">
                                            <p class="text-sm font-medium text-gray-900 dark:text-white">
                                                #{{ $ticket->id }} - {{ $ticket->title }}
                                            </p>
                                            <span class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ $ticket->created_at->diffForHumans() }}
                                            </span>
                                        </div>
                                        <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">
                                            {{ $ticket->priority }} • {{ ucfirst($ticket->status) }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @elseif($activeTab === 'edit')
        {{-- Formulário de Edição --}}
        <div class="bg-white dark:bg-gray-800 rounded-lg p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center space-x-4">
                    <button wire:click="goToList"
                        class="text-gray-400 hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </button>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                        Editar Subscrição #{{ $selectedSubscription->id ?? '' }}
                    </h3>
                </div>
            </div>

            <form wire:submit="saveSubscription">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Status --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status *</label>
                        <select wire:model="status"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white @error('status') border-red-500 @enderror">
                            <option value="pending_installation">Pendente Instalação</option>
                            <option value="active">Ativa</option>
                            <option value="suspended">Suspensa</option>
                            <option value="cancelled">Cancelada</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Preço Mensal --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Preço Mensal
                            (MT) *</label>
                        <input type="number" wire:model="monthly_price" step="0.01" min="0"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white @error('monthly_price') border-red-500 @enderror">
                        @error('monthly_price')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Data de Início --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Data de Início
                            *</label>
                        <input type="date" wire:model="start_date"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white @error('start_date') border-red-500 @enderror">
                        @error('start_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Data de Término --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Data de
                            Término</label>
                        <input type="date" wire:model="end_date"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white @error('end_date') border-red-500 @enderror">
                        @error('end_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Taxa de Instalação --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Taxa de
                            Instalação (MT)</label>
                        <input type="number" wire:model="installation_fee" step="0.01" min="0"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white @error('installation_fee') border-red-500 @enderror">
                        @error('installation_fee')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Dia de Vencimento --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Dia do
                            Vencimento *</label>
                        <select wire:model="billing_day"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white @error('billing_day') border-red-500 @enderror">
                            @for ($day = 1; $day <= 28; $day++)
                                <option value="{{ $day }}">Dia {{ $day }}</option>
                            @endfor
                        </select>
                        @error('billing_day')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Auto Renovação --}}
                    <div>
                        <div class="flex items-center">
                            <input type="checkbox" wire:model="auto_renew"
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label class="ml-2 block text-sm text-gray-900 dark:text-white">
                                Renovação Automática
                            </label>
                        </div>
                    </div>
                </div>

                {{-- Observações --}}
                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Observações</label>
                    <textarea wire:model="notes" rows="4" placeholder="Observações sobre esta subscrição..."
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white @error('notes') border-red-500 @enderror"></textarea>
                    @error('notes')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Ações --}}
                <div class="mt-8 flex items-center justify-end space-x-4">
                    <button type="button" wire:click="goToList"
                        class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700">
                        Cancelar
                    </button>
                    <button type="submit"
                        class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md transition-colors">
                        Atualizar Subscrição
                    </button>
                </div>
            </form>
        </div>
    @endif

    {{-- Toast Messages --}}
    @if (session()->has('message'))
        <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 5000)"
            class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 7000)"
            class="fixed bottom-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
            {{ session('error') }}
        </div>
    @endif

    {{-- Loading States --}}
    <div wire:loading class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" x-cloak>
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
            <div class="mt-3 text-center">
                <div
                    class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 dark:bg-blue-900/20">
                    <svg class="animate-spin h-6 w-6 text-blue-600" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                        </path>
                    </svg>
                </div>
                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white mt-2">Processando...</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Aguarde enquanto processamos sua solicitação.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('dropdown', () => ({
                open: false,
                toggle() {
                    this.open = !this.open
                }
            }))
        })
    </script>
</div>
