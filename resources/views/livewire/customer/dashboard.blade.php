<div>
    {{-- Page Header --}}
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
            Olá, {{ $customer->name }}! 👋
        </h1>
        <p class="mt-2 text-gray-600 dark:text-gray-400">
            Bem-vindo ao seu portal. Aqui está um resumo da sua conta.
        </p>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

        {{-- Subscrições Ativas --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Subscrições Ativas</p>
                    <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">
                        {{ $stats['active_subscriptions'] }}
                    </p>
                </div>
                <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0" />
                    </svg>
                </div>
            </div>
            <a href="{{ route('customer.subscriptions.index') }}" wire:navigate
                class="mt-4 text-sm text-blue-600 dark:text-blue-400 hover:underline inline-flex items-center gap-1">
                Ver detalhes
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>

        {{-- Faturas Pendentes --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Faturas Pendentes</p>
                    <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">
                        {{ $stats['pending_invoices'] }}
                    </p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 dark:bg-yellow-900 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
            </div>
            <a href="{{ route('customer.invoices.index') }}" wire:navigate
                class="mt-4 text-sm text-blue-600 dark:text-blue-400 hover:underline inline-flex items-center gap-1">
                Ver faturas
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>

        {{-- Tickets Abertos --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Tickets Abertos</p>
                    <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">
                        {{ $stats['open_tickets'] }}
                    </p>
                </div>
                <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
            </div>
            <a {{-- href="{{ route('customer.tickets.index') }}"  --}} wire:navigate
                class="mt-4 text-sm text-blue-600 dark:text-blue-400 hover:underline inline-flex items-center gap-1">
                Ver tickets
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>

        {{-- Total Gasto --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Pago</p>
                    <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">
                        {{ number_format($stats['total_spent'], 2, ',', '.') }} MT
                    </p>
                </div>
                <div class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Subscrições Ativas --}}
        <div
            class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Minhas Subscrições</h2>
                    <a href="{{ route('customer.subscriptions.index') }}" wire:navigate
                        class="text-sm text-blue-600 dark:text-blue-400 hover:underline">
                        Ver todas
                    </a>
                </div>
            </div>

            <div class="p-6">
                @if ($activeSubscriptions->count() > 0)
                    <div class="space-y-4">
                        @foreach ($activeSubscriptions as $subscription)
                            <div
                                class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center">
                                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-900 dark:text-white">
                                            {{ $subscription->plan->name }}
                                        </h3>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            {{ $subscription->plan->download_speed }}MB -
                                            {{ number_format($subscription->monthly_price, 2, ',', '.') }} MT/mês
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">
                                            {{ $subscription->installationAddress->city ?? 'N/A' }}
                                        </p>
                                    </div>
                                </div>
                                <a href="{{ route('customer.subscriptions.show', $subscription->id) }}" wire:navigate
                                    class="px-4 py-2 text-sm font-medium text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-lg transition">
                                    Ver detalhes
                                </a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 mx-auto text-gray-300 dark:text-gray-600 mb-4" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0" />
                        </svg>
                        <p class="text-gray-600 dark:text-gray-400">Nenhuma subscrição ativa</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Sidebar: Próxima Fatura + Tickets --}}
        <div class="space-y-6">

            {{-- Próxima Fatura --}}
            @if ($nextDueInvoice)
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Próxima Fatura</h3>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-600 dark:text-gray-400">Número:</span>
                            <span
                                class="font-medium text-gray-900 dark:text-white">{{ $nextDueInvoice->invoice_number }}</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-600 dark:text-gray-400">Valor:</span>
                            <span class="font-semibold text-gray-900 dark:text-white">
                                {{ number_format($nextDueInvoice->total_amount, 2, ',', '.') }} MT
                            </span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-600 dark:text-gray-400">Vencimento:</span>
                            <span class="font-medium text-orange-600 dark:text-orange-400">
                                {{ $nextDueInvoice->due_date->format('d/m/Y') }}
                            </span>
                        </div>
                    </div>
                    <a href="{{ route('customer.invoices.show', $nextDueInvoice->id) }}" wire:navigate
                        class="mt-4 block w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-center font-medium rounded-lg transition">
                        Ver Fatura
                    </a>
                </div>
            @endif

            {{-- Tickets Recentes --}}
            <div
                class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-semibold text-gray-900 dark:text-white">Tickets Recentes</h3>
                    <a {{-- href="{{ route('customer.tickets.create') }}"  --}} wire:navigate
                        class="text-sm text-blue-600 dark:text-blue-400 hover:underline">
                        Abrir novo
                    </a>
                </div>

                @if ($openTickets->count() > 0)
                    <div class="space-y-3">
                        @foreach ($openTickets->take(3) as $ticket)
                            <a {{-- href="{{ route('customer.tickets.show', $ticket->id) }}"  --}} wire:navigate
                                class="block p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                                <div class="flex items-start justify-between gap-2">
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                            {{ $ticket->subject }}
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                            {{ $ticket->ticket_number }} • {{ $ticket->opened_at->diffForHumans() }}
                                        </p>
                                    </div>
                                    <span
                                        class="px-2 py-1 text-xs font-medium rounded-full
                                        @if ($ticket->status === 'open') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300
                                        @elseif($ticket->status === 'in_progress') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300
                                        @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 @endif">
                                        {{ ucfirst($ticket->status) }}
                                    </span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="w-12 h-12 mx-auto text-gray-300 dark:text-gray-600 mb-2" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Nenhum ticket aberto</p>
                    </div>
                @endif
            </div>

            {{-- Quick Actions --}}
            <div class="bg-blue-600 dark:bg-blue-700 rounded-xl shadow-sm p-6 text-white">
                <h3 class="font-semibold mb-4">Ações Rápidas</h3>
                <div class="space-y-2">
                    <a href="{{ route('customer.plans.index') }}" wire:navigate
                        class="block px-4 py-2 bg-white/20 hover:bg-white/30 rounded-lg text-sm font-medium transition flex items-center gap-2">
                        Fazer Upgrade
                    </a>
                    <a href="{{ route('customer.tickets.create') }}" wire:navigate
                        class="block px-4 py-2 bg-white/20 hover:bg-white/30 rounded-lg text-sm font-medium transition flex items-center gap-2">
                        Abrir Ticket
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
