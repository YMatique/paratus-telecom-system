<div class="space-y-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Gestão de Faturas</h1>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                Gerencie faturas, cobranças e registre pagamentos
            </p>
        </div>

        @if ($activeTab === 'list')
            <button wire:click="createInvoice"
                class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Nova Fatura
            </button>
        @endif
    </div>

    {{-- Stats Cards --}}
    @if ($activeTab === 'list')
        <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
            {{-- Total Faturas --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 border border-gray-200 dark:border-gray-700">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900/20">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Faturas</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total_invoices'] }}</p>
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
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">A Receber</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">
                            {{ number_format($stats['pending_amount'], 0, ',', '.') }} MT</p>
                    </div>
                </div>
            </div>

            {{-- Pagas --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 border border-gray-200 dark:border-gray-700">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 dark:bg-green-900/20">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Recebido</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">
                            {{ number_format($stats['paid_amount'], 0, ',', '.') }} MT</p>
                    </div>
                </div>
            </div>

            {{-- Vencidas --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 border border-gray-200 dark:border-gray-700">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-red-100 dark:bg-red-900/20">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z">
                            </path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Vencidas</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['overdue_count'] }}</p>
                    </div>
                </div>
            </div>

            {{-- Vencem Hoje --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 border border-gray-200 dark:border-gray-700">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-orange-100 dark:bg-orange-900/20">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Vencem Hoje</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['due_today'] }}</p>
                    </div>
                </div>
            </div>

            {{-- Receita Mensal --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 border border-gray-200 dark:border-gray-700">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-purple-100 dark:bg-purple-900/20">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1">
                            </path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Receita Mensal</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">
                            {{ number_format($stats['monthly_revenue'], 0, ',', '.') }} MT</p>
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
                    <input type="text" wire:model.live="search" placeholder="Número da fatura, cliente..."
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                </div>

                {{-- Status --}}
                <div class="w-full lg:w-48">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                    <select wire:model.live="filterStatus"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        <option value="all">Todas</option>
                        <option value="pending">Pendentes</option>
                        <option value="paid">Pagas</option>
                        <option value="overdue">Vencidas</option>
                        <option value="cancelled">Canceladas</option>
                    </select>
                </div>

                {{-- Vencimento --}}
                <div class="w-full lg:w-48">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Vencimento</label>
                    <select wire:model.live="filterDueDate"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        <option value="all">Todas</option>
                        <option value="due_today">Vencem Hoje</option>
                        <option value="due_week">Próximos 7 dias</option>
                        <option value="overdue">Em Atraso</option>
                    </select>
                </div>

                {{-- Cliente --}}
                <div class="w-full lg:w-64">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Cliente</label>
                    <select wire:model.live="filterCustomer"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        <option value="all">Todos</option>
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Bulk Actions --}}
            @if (count($selectedInvoices) > 0)
                <div class="flex items-center justify-between mt-4 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                    <span class="text-sm text-blue-800 dark:text-blue-200">
                        {{ count($selectedInvoices) }} fatura(s) selecionada(s)
                    </span>
                    <div class="flex items-center space-x-4">
                        <select wire:model="bulkAction"
                            class="px-3 py-1 border border-blue-300 dark:border-blue-600 rounded text-sm bg-white dark:bg-gray-700">
                            <option value="">Selecione ação</option>
                            <option value="mark_overdue">Marcar como Vencidas</option>
                            <option value="cancel">Cancelar</option>
                        </select>
                        <button wire:click="executeBulkAction"
                            class="px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded transition-colors">
                            Executar
                        </button>
                    </div>
                </div>
            @endif
        </div>

        {{-- Tabela de Faturas --}}
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
                                Número
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Cliente
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Status
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Valor
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Vencimento
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Emissão
                            </th>
                            <th
                                class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Ações
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($invoices as $invoice)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-6 py-4">
                                    <input type="checkbox" wire:model="selectedInvoices" value="{{ $invoice->id }}"
                                        class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $invoice->invoice_number }}
                                    </div>
                                    @if ($invoice->subscription)
                                        <div class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $invoice->subscription->plan->name ?? 'Plano' }}
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $invoice->customer->name }}
                                    </div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $invoice->customer->document }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $statusConfig = [
                                            'pending' => [
                                                'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400',
                                                'Pendente',
                                            ],
                                            'paid' => [
                                                'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400',
                                                'Paga',
                                            ],
                                            'overdue' => [
                                                'bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400',
                                                'Vencida',
                                            ],
                                            'cancelled' => [
                                                'bg-gray-100 text-gray-800 dark:bg-gray-900/20 dark:text-gray-400',
                                                'Cancelada',
                                            ],
                                        ][$invoice->status] ?? ['bg-gray-100 text-gray-800', 'Desconhecido'];

                                        // Override para vencidas
                                        if ($invoice->status === 'pending' && $invoice->isOverdue()) {
                                            $statusConfig = [
                                                'bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400',
                                                'Vencida',
                                            ];
                                        }
                                    @endphp
                                    <span
                                        class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $statusConfig[0] }}">
                                        {{ $statusConfig[1] }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ number_format($invoice->total_amount, 2, ',', '.') }} MT
                                    </div>
                                    @if ($invoice->status === 'pending' && $invoice->getRemainingAmount() < $invoice->total_amount)
                                        <div class="text-xs text-blue-600">
                                            Restam: {{ number_format($invoice->getRemainingAmount(), 2, ',', '.') }} MT
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900 dark:text-white">
                                        {{ $invoice->due_date->format('d/m/Y') }}
                                    </div>
                                    @if ($invoice->status === 'pending' && $invoice->isOverdue())
                                        <div class="text-xs text-red-600">
                                            {{ $invoice->getDaysOverdue() }} dias em atraso
                                        </div>
                                    @elseif($invoice->status === 'pending')
                                        @php $daysUntilDue = now()->diffInDays($invoice->due_date, false); @endphp
                                        @if ($daysUntilDue <= 7)
                                            <div class="text-xs text-yellow-600">
                                                {{ $daysUntilDue }} dias restantes
                                            </div>
                                        @endif
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">
                                    {{ $invoice->issue_date->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 text-right text-sm font-medium">
                                    <div class="flex items-center justify-end space-x-2">
                                        {{-- Visualizar --}}
                                        <button wire:click="viewInvoice({{ $invoice->id }})"
                                            class="text-blue-600 hover:text-blue-900 dark:text-blue-400"
                                            title="Visualizar">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                </path>
                                            </svg>
                                        </button>

                                        {{-- Registrar Pagamento --}}
                                        @if ($invoice->status === 'pending')
                                            <button wire:click="showPaymentForm({{ $invoice->id }})"
                                                class="text-green-600 hover:text-green-900 dark:text-green-400"
                                                title="Registrar Pagamento">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1">
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
                                                    <button wire:click="duplicateInvoice({{ $invoice->id }})"
                                                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                                        Duplicar Fatura
                                                    </button>
                                                    @if ($invoice->status === 'pending')
                                                        <hr class="border-gray-200 dark:border-gray-600">
                                                        <button wire:click="cancelInvoice({{ $invoice->id }})"
                                                            class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100 dark:hover:bg-gray-700">
                                                            Cancelar Fatura
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
                                        <h3 class="text-lg font-medium mb-2">Nenhuma fatura encontrada</h3>
                                        <p class="text-sm mb-4">Comece criando uma nova fatura</p>
                                        <button wire:click="createInvoice"
                                            class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 4v16m8-8H4"></path>
                                            </svg>
                                            Criar Primeira Fatura
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Paginação --}}
            @if ($invoices->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                    {{ $invoices->links() }}
                </div>
            @endif
        </div>
    @elseif($activeTab === 'create')
        {{-- Formulário de Criação --}}
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-medium text-gray-900">Nova Fatura</h3>
                    <button wire:click="goToList" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <form wire:submit="saveInvoice" class="p-6 space-y-6">
                {{-- Dados Básicos --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Cliente --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Cliente *</label>
                        <select wire:model.live="customer_id"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 @error('customer_id') border-red-500 @enderror">
                            <option value="">Selecione um cliente</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}">
                                    {{ $customer->name }} - {{ $customer->document }}
                                </option>
                            @endforeach
                        </select>
                        @error('customer_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Subscrição --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Subscrição (Opcional)</label>
                        <select wire:model.live="subscription_id"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Fatura avulsa</option>
                            @foreach ($subscriptions as $subscription)
                                <option value="{{ $subscription->id }}">
                                    {{ $subscription->plan->name }} -
                                    {{ number_format($subscription->monthly_price, 0, ',', '.') }} MT
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Data Emissão --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Data de Emissão *</label>
                        <input type="date" wire:model="issue_date"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 @error('issue_date') border-red-500 @enderror">
                        @error('issue_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    {{-- Data Vencimento --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Data de Vencimento *</label>
                        <input type="date" wire:model="due_date"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 @error('due_date') border-red-500 @enderror">
                        @error('due_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Itens da Fatura --}}
                <div>
                    <h4 class="text-lg font-medium text-gray-900 mb-4">Itens da Fatura</h4>

                    {{-- Lista de Itens Existentes --}}
                    @if (count($invoiceItems) > 0)
                        <div class="mb-4 border border-gray-200 rounded-lg overflow-hidden">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                            Descrição</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Qtd
                                        </th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                            Preço Unit.</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                            Total</th>
                                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">
                                            Ações</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($invoiceItems as $index => $item)
                                        <tr>
                                            <td class="px-4 py-3 text-sm text-gray-900">{{ $item['description'] }}
                                            </td>
                                            <td class="px-4 py-3 text-sm text-gray-900">{{ $item['quantity'] }}</td>
                                            <td class="px-4 py-3 text-sm text-gray-900">
                                                {{ number_format($item['unit_price'], 2, ',', '.') }} MT</td>
                                            <td class="px-4 py-3 text-sm text-gray-900">
                                                {{ number_format($item['total_price'], 2, ',', '.') }} MT</td>
                                            <td class="px-4 py-3 text-right">
                                                <button type="button" wire:click="removeItem({{ $index }})"
                                                    class="text-red-600 hover:text-red-900">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                    {{-- Adicionar Novo Item --}}
                    <div class="border border-gray-200 rounded-lg p-4">
                        <h5 class="font-medium text-gray-900 mb-3">Adicionar Item</h5>
                        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Descrição</label>
                                <input type="text" wire:model="newItem.description"
                                    placeholder="Ex: Plano Fibra 100MB"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Quantidade</label>
                                <input type="number" wire:model="newItem.quantity" min="1"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Preço (MT)</label>
                                <input type="number" wire:model="newItem.unit_price" step="0.01" min="0"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div class="flex items-end">
                                <button type="button" wire:click="addItem"
                                    class="w-full px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-md transition-colors">
                                    Adicionar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Resumo Financeiro --}}
                <div class="bg-gray-50 rounded-lg p-6">
                    <h4 class="text-lg font-medium text-gray-900 mb-4">Resumo</h4>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Subtotal:</span>
                            <span
                                class="text-sm font-medium text-gray-900">{{ number_format((float) $subtotal, 2, ',', '.') }}
                                MT</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">IVA (17%):</span>
                            <span
                                class="text-sm font-medium text-gray-900">{{ number_format((float) $tax_amount, 2, ',', '.') }}
                                MT</span>
                        </div>
                        @if ($discount_amount > 0)
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Desconto:</span>
                                <span
                                    class="text-sm font-medium text-red-600">-{{ number_format((float) $discount_amount, 2, ',', '.') }}
                                    MT</span>
                            </div>
                        @endif
                        <hr class="border-gray-200">
                        <div class="flex justify-between">
                            <span class="text-lg font-bold text-gray-900">Total:</span>
                            <span
                                class="text-lg font-bold text-gray-900">{{ number_format((float) $total_amount, 2, ',', '.') }}
                                MT</span>
                        </div>
                    </div>

                    {{-- Campo de Desconto --}}
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Desconto (MT)</label>
                        <input type="number" wire:model.live="discount_amount" step="0.01" min="0"
                            wire:change="calculateTotals"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                {{-- Observações --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Observações</label>
                    <textarea wire:model="notes" rows="3" placeholder="Observações sobre esta fatura..."
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"></textarea>
                </div>

                {{-- Ações --}}
                <div class="flex items-center justify-end space-x-4 pt-4 border-t border-gray-200">
                    <button type="button" wire:click="goToList"
                        class="px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        Cancelar
                    </button>
                    <button type="submit"
                        class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md transition-colors">
                        Criar Fatura
                    </button>
                </div>
            </form>
        </div>
    @elseif($activeTab === 'view')
        {{-- Visualização Detalhada --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Informações Principais --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- Cabeçalho --}}
                <div class="bg-white rounded-lg p-6 border border-gray-200">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center space-x-4">
                            <button wire:click="goToList" class="text-gray-400 hover:text-gray-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 19l-7-7 7-7"></path>
                                </svg>
                            </button>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">
                                    Fatura {{ $selectedInvoice->invoice_number ?? '' }}
                                </h3>
                                <p class="text-sm text-gray-600">
                                    Emitida em
                                    {{ $selectedInvoice->issue_date ? $selectedInvoice->issue_date->format('d/m/Y') : '' }}
                                </p>
                            </div>
                        </div>

                        @if ($selectedInvoice && $selectedInvoice->status === 'pending')
                            <button wire:click="showPaymentForm({{ $selectedInvoice->id }})"
                                class="inline-flex items-center px-3 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-md transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1">
                                    </path>
                                </svg>
                                Registrar Pagamento
                            </button>
                        @endif
                    </div>

                    {{-- Status e Info Rápida --}}
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Status</label>
                            @if ($selectedInvoice)
                                @php
                                    $statusConfig = [
                                        'pending' => ['bg-yellow-100 text-yellow-800', 'Pendente'],
                                        'paid' => ['bg-green-100 text-green-800', 'Paga'],
                                        'cancelled' => ['bg-gray-100 text-gray-800', 'Cancelada'],
                                    ][$selectedInvoice->status] ?? ['bg-gray-100 text-gray-800', 'Desconhecido'];

                                    if ($selectedInvoice->status === 'pending' && $selectedInvoice->isOverdue()) {
                                        $statusConfig = ['bg-red-100 text-red-800', 'Vencida'];
                                    }
                                @endphp
                                <span
                                    class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $statusConfig[0] }}">
                                    {{ $statusConfig[1] }}
                                </span>
                            @endif
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Valor Total</label>
                            <p class="text-sm font-medium text-gray-900">
                                {{ number_format($selectedInvoice->total_amount ?? 0, 2, ',', '.') }} MT
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Vencimento</label>
                            <p class="text-sm font-medium text-gray-900">
                                {{ $selectedInvoice->due_date ? $selectedInvoice->due_date->format('d/m/Y') : '-' }}
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Saldo Devedor</label>
                            <p class="text-sm font-medium text-gray-900">
                                {{ number_format($selectedInvoice->getRemainingAmount() ?? 0, 2, ',', '.') }} MT
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Dados do Cliente --}}
                <div class="bg-white rounded-lg p-6 border border-gray-200">
                    <h4 class="text-lg font-medium text-gray-900 mb-4">Dados do Cliente</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Nome:</p>
                            <p class="font-medium text-gray-900">{{ $selectedInvoice->customer->name ?? '' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Documento:</p>
                            <p class="font-medium text-gray-900">{{ $selectedInvoice->customer->document ?? '' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Email:</p>
                            <p class="font-medium text-gray-900">{{ $selectedInvoice->customer->email ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Telefone:</p>
                            <p class="font-medium text-gray-900">{{ $selectedInvoice->customer->phone ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                {{-- Itens da Fatura --}}
                <div class="bg-white rounded-lg p-6 border border-gray-200">
                    <h4 class="text-lg font-medium text-gray-900 mb-4">Itens</h4>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                                        Descrição</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Qtd
                                    </th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Preço
                                        Unit.</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Total
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($selectedInvoice->items ?? [] as $item)
                                    <tr>
                                        <td class="px-4 py-2 text-sm text-gray-900">{{ $item->description }}</td>
                                        <td class="px-4 py-2 text-sm text-gray-900">{{ $item->quantity }}</td>
                                        <td class="px-4 py-2 text-sm text-gray-900">
                                            {{ number_format($item->unit_price, 2, ',', '.') }} MT</td>
                                        <td class="px-4 py-2 text-sm text-gray-900">
                                            {{ number_format($item->total_price, 2, ',', '.') }} MT</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-4 py-4 text-center text-sm text-gray-500">
                                            Nenhum item encontrado
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Resumo Financeiro --}}
                    <div class="mt-6 pt-4 border-t border-gray-200">
                        <div class="flex justify-end">
                            <div class="w-64 space-y-2">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Subtotal:</span>
                                    <span
                                        class="text-gray-900">{{ number_format($selectedInvoice->subtotal ?? 0, 2, ',', '.') }}
                                        MT</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">IVA (17%):</span>
                                    <span
                                        class="text-gray-900">{{ number_format($selectedInvoice->tax_amount ?? 0, 2, ',', '.') }}
                                        MT</span>
                                </div>
                                @if ($selectedInvoice->discount_amount > 0)
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600">Desconto:</span>
                                        <span
                                            class="text-red-600">-{{ number_format($selectedInvoice->discount_amount, 2, ',', '.') }}
                                            MT</span>
                                    </div>
                                @endif
                                <hr class="border-gray-200">
                                <div class="flex justify-between font-bold">
                                    <span class="text-gray-900">Total:</span>
                                    <span
                                        class="text-gray-900">{{ number_format($selectedInvoice->total_amount ?? 0, 2, ',', '.') }}
                                        MT</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sidebar de Ações --}}
            <div class="space-y-6">
                {{-- Ações Rápidas --}}
                <div class="bg-white rounded-lg p-6 border border-gray-200">
                    <h4 class="text-lg font-medium text-gray-900 mb-4">Ações</h4>
                    <div class="space-y-3">
                        @if ($selectedInvoice && $selectedInvoice->status === 'pending')
                            <button wire:click="showPaymentForm({{ $selectedInvoice->id }})"
                                class="w-full flex items-center justify-center px-3 py-2 border border-green-300 text-sm font-medium rounded-md text-green-700 hover:bg-green-50">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1">
                                    </path>
                                </svg>
                                Registrar Pagamento
                            </button>
                        @endif

                        <button wire:click="duplicateInvoice({{ $selectedInvoice->id ?? '' }})"
                            class="w-full flex items-center justify-center px-3 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 hover:bg-gray-50">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z">
                                </path>
                            </svg>
                            Duplicar Fatura
                        </button>

                        @if ($selectedInvoice && $selectedInvoice->status === 'pending')
                            <hr class="border-gray-200">
                            <button wire:click="cancelInvoice({{ $selectedInvoice->id }})"
                                class="w-full flex items-center justify-center px-3 py-2 border border-red-300 text-sm font-medium rounded-md text-red-700 hover:bg-red-50">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                    </path>
                                </svg>
                                Cancelar Fatura
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @elseif($activeTab === 'payment')
        {{-- Formulário de Pagamento --}}
        <div class="max-w-2xl mx-auto bg-white rounded-lg border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-medium text-gray-900">Registrar Pagamento</h3>
                    <button wire:click="viewInvoice({{ $selectedInvoice->id ?? '' }})"
                        class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <div class="p-6">
                {{-- Informações da Fatura --}}
                <div class="mb-6 p-4 bg-blue-50 rounded-lg">
                    <h4 class="font-medium text-blue-900 mb-2">Fatura {{ $selectedInvoice->invoice_number ?? '' }}
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-blue-800"><strong>Cliente:</strong>
                                {{ $selectedInvoice->customer->name ?? '' }}</p>
                            <p class="text-blue-800"><strong>Total:</strong>
                                {{ number_format($selectedInvoice->total_amount ?? 0, 2, ',', '.') }} MT</p>
                        </div>
                        <div>
                            <p class="text-blue-800"><strong>Saldo Devedor:</strong>
                                {{ number_format($selectedInvoice->getRemainingAmount() ?? 0, 2, ',', '.') }} MT</p>
                            <p class="text-blue-800"><strong>Vencimento:</strong>
                                {{ $selectedInvoice->due_date ? $selectedInvoice->due_date->format('d/m/Y') : '' }}</p>
                        </div>
                    </div>
                </div>

                <form wire:submit="registerPayment" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Valor --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Valor do Pagamento (MT)
                                *</label>
                            <input type="number" wire:model="payment_amount" step="0.01" min="0.01"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 @error('payment_amount') border-red-500 @enderror">
                            @error('payment_amount')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Método --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Método de Pagamento *</label>
                            <select wire:model="payment_method"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 @error('payment_method') border-red-500 @enderror">
                                <option value="mpesa">M-Pesa</option>
                                <option value="emola">e-Mola</option>
                                <option value="mkesh">mKesh</option>
                                <option value="cash">Dinheiro</option>
                                <option value="bank_transfer">Transferência Bancária</option>
                                <option value="card">Cartão</option>
                            </select>
                            @error('payment_method')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Referência --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Referência do Pagamento</label>
                            <input type="text" wire:model="payment_reference"
                                placeholder="Ex: TXN123456789, Recibo #001..."
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                            <p class="mt-1 text-xs text-gray-500">Número da transação, recibo ou referência</p>
                        </div>

                        {{-- Data --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Data do Pagamento *</label>
                            <input type="date" wire:model="payment_date"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 @error('payment_date') border-red-500 @enderror">
                            @error('payment_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Observações --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Observações</label>
                        <textarea wire:model="payment_notes" rows="3" placeholder="Observações sobre este pagamento..."
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"></textarea>
                    </div>

                    {{-- Ações --}}
                    <div class="flex items-center justify-end space-x-4 pt-4 border-t border-gray-200">
                        <button type="button" wire:click="viewInvoice({{ $selectedInvoice->id ?? '' }})"
                            class="px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            Cancelar
                        </button>
                        <button type="submit"
                            class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-md transition-colors">
                            Registrar Pagamento
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>