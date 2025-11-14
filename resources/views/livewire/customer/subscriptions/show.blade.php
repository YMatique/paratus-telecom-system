<div>
    {{-- Breadcrumb --}}
    <nav class="flex mb-6" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('customer.subscriptions.index') }}" 
                   wire:navigate
                   class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                    Subscrições
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-3 h-3 text-gray-400 mx-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">
                        {{ $subscription->plan->name }}
                    </span>
                </div>
            </li>
        </ol>
    </nav>

    {{-- Header --}}
    <div class="mb-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                    {{ $subscription->plan->name }}
                </h1>
                <p class="mt-2 text-gray-600 dark:text-gray-400">
                    Subscrição ativa desde {{ $subscription->start_date->format('d/m/Y') }}
                </p>
            </div>

            {{-- Status Badge --}}
            <span class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold rounded-lg
                @if($subscription->status === 'active') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                @elseif($subscription->status === 'suspended') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300
                @elseif($subscription->status === 'cancelled') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300
                @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300
                @endif">
                @if($subscription->status === 'active')
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Ativa
                @elseif($subscription->status === 'suspended')
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Suspensa
                @elseif($subscription->status === 'cancelled')
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Cancelada
                @else
                    {{ ucfirst($subscription->status) }}
                @endif
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- Main Content --}}
        <div class="lg:col-span-2 space-y-6">
            
            {{-- Detalhes do Plano --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Detalhes do Plano</h2>
                </div>
                
                <div class="p-6 space-y-6">
                    {{-- Velocidades --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm text-blue-600 dark:text-blue-400 font-medium">Download</p>
                                    <p class="text-2xl font-bold text-blue-900 dark:text-blue-200">
                                        {{ $subscription->plan->download_speed }} MB/s
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="p-4 bg-purple-50 dark:bg-purple-900/20 rounded-lg border border-purple-200 dark:border-purple-800">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="w-10 h-10 bg-purple-600 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm text-purple-600 dark:text-purple-400 font-medium">Upload</p>
                                    <p class="text-2xl font-bold text-purple-900 dark:text-purple-200">
                                        {{ $subscription->plan->upload_speed }} MB/s
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Preço e Billing --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                            <span class="text-gray-600 dark:text-gray-400">Mensalidade</span>
                            <span class="font-semibold text-gray-900 dark:text-white">
                                {{ number_format($subscription->monthly_price, 2, ',', '.') }} MT
                            </span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                            <span class="text-gray-600 dark:text-gray-400">Tipo de Plano</span>
                            <span class="font-medium text-gray-900 dark:text-white">
                                {{ ucfirst($subscription->plan->type) }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                            <span class="text-gray-600 dark:text-gray-400">Data de Início</span>
                            <span class="font-medium text-gray-900 dark:text-white">
                                {{ $subscription->start_date->format('d/m/Y') }}
                            </span>
                        </div>
                        @if($subscription->next_billing_date)
                            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                                <span class="text-gray-600 dark:text-gray-400">Próx. Cobrança</span>
                                <span class="font-medium text-gray-900 dark:text-white">
                                    {{ $subscription->next_billing_date->format('d/m/Y') }}
                                </span>
                            </div>
                        @endif
                    </div>

                    {{-- Descrição do Plano --}}
                    @if($subscription->plan->description)
                        <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                            <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Sobre o Plano</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                {{ $subscription->plan->description }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Endereço de Instalação --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Endereço de Instalação</h2>
                </div>
                
                <div class="p-6">
                    @if($subscription->installationAddress)
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-red-100 dark:bg-red-900/30 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="font-medium text-gray-900 dark:text-white mb-1">
                                    {{ $subscription->installationAddress->full_address }}
                                </p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ $subscription->installationAddress->city }}, {{ $subscription->installationAddress->province }}
                                </p>
                                @if($subscription->installationAddress->reference)
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                                        <span class="font-medium">Referência:</span> {{ $subscription->installationAddress->reference }}
                                    </p>
                                @endif
                                @if($subscription->installationAddress->latitude && $subscription->installationAddress->longitude)
                                    <a href="{{ $subscription->installationAddress->google_maps_url }}" 
                                       target="_blank"
                                       class="inline-flex items-center gap-1 mt-3 text-sm text-blue-600 dark:text-blue-400 hover:underline">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                        </svg>
                                        Ver no Google Maps
                                    </a>
                                @endif
                            </div>
                        </div>
                    @else
                        <p class="text-gray-500 dark:text-gray-400">Endereço não cadastrado</p>
                    @endif
                </div>
            </div>

            {{-- Equipamentos Instalados --}}
            @if($equipment->count() > 0)
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Equipamentos</h2>
                    </div>
                    
                    <div class="p-6">
                        <div class="space-y-4">
                            @foreach($equipment as $item)
                                <div class="flex items-center gap-4 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600">
                                    <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg flex items-center justify-center">
                                        <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="font-semibold text-gray-900 dark:text-white">
                                            {{ $item->product->name }}
                                        </h3>
                                        @if($item->equipment)
                                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                                SN: {{ $item->equipment->serial_number }}
                                                @if($item->equipment->mac_address)
                                                    • MAC: {{ $item->equipment->mac_address }}
                                                @endif
                                            </p>
                                        @endif
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                            Quantidade: {{ $item->quantity }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            {{-- Faturas Recentes --}}
            @if($invoices->count() > 0)
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Faturas Recentes</h2>
                        <a href="{{ route('customer.invoices.index') }}" 
                           wire:navigate
                           class="text-sm text-blue-600 dark:text-blue-400 hover:underline">
                            Ver todas
                        </a>
                    </div>
                    
                    <div class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($invoices as $invoice)
                            <div 
                                wire:click="viewInvoice({{ $invoice->id }})"
                                class="p-4 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition cursor-pointer">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-white">
                                            {{ $invoice->invoice_number }}
                                        </p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            Vencimento: {{ $invoice->due_date->format('d/m/Y') }}
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-semibold text-gray-900 dark:text-white">
                                            {{ number_format($invoice->total_amount, 2, ',', '.') }} MT
                                        </p>
                                        <span class="inline-block px-2 py-1 text-xs font-medium rounded-full mt-1
                                            @if($invoice->status === 'paid') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                                            @elseif($invoice->status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300
                                            @elseif($invoice->status === 'overdue') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300
                                            @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300
                                            @endif">
                                            @if($invoice->status === 'paid') Paga
                                            @elseif($invoice->status === 'pending') Pendente
                                            @elseif($invoice->status === 'overdue') Vencida
                                            @else {{ ucfirst($invoice->status) }}
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">
            
            {{-- Quick Actions --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Ações Rápidas</h3>
                <div class="space-y-2">
                    <button 
                        wire:click="requestUpgrade"
                        class="w-full px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        Fazer Upgrade
                    </button>
                    
                    <button 
                        wire:click="openTicket"
                        class="w-full px-4 py-3 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg transition flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        Abrir Ticket
                    </button>
                </div>
            </div>

            {{-- Tickets Relacionados --}}
            @if($tickets->count() > 0)
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Tickets Relacionados</h3>
                    <div class="space-y-3">
                        @foreach($tickets as $ticket)
                            <div 
                                wire:click="viewTicket({{ $ticket->id }})"
                                class="p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition cursor-pointer">
                                <div class="flex items-start justify-between gap-2">
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                            {{ $ticket->subject }}
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                            {{ $ticket->ticket_number }} • {{ $ticket->opened_at->diffForHumans() }}
                                        </p>
                                    </div>
                                    <span class="px-2 py-1 text-xs font-medium rounded-full flex-shrink-0
                                        @if($ticket->status === 'open') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300
                                        @elseif($ticket->status === 'in_progress') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300
                                        @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300
                                        @endif">
                                        {{ ucfirst($ticket->status) }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Suporte --}}
            <div class="bg-gradient-to-br from-orange-500 to-red-600 rounded-xl shadow-sm p-6 text-white">
                <div class="flex items-start gap-3 mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    <div>
                        <h3 class="font-semibold mb-1">Precisa de ajuda?</h3>
                        <p class="text-sm opacity-90">
                            Nossa equipe está disponível 24/7
                        </p>
                    </div>
                </div>
                <a href="tel:+258840000000" class="block w-full px-4 py-2 bg-white/20 hover:bg-white/30 text-center font-medium rounded-lg transition">
                    📞 +258 84 000 0000
                </a>
            </div>
        </div>
    </div>
</div>