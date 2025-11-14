<div>
    {{-- Page Header --}}
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Meus Tickets</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">
                Gerencie suas solicitações de suporte
            </p>
        </div>
        <a href="{{ route('customer.tickets.create') }}" 
           wire:navigate
           class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition shadow-lg">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Abrir Novo Ticket
        </a>
    </div>

    {{-- Filters --}}
    <div class="mb-6 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
        
        {{-- Search Bar --}}
        <div class="mb-4">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input 
                    type="text" 
                    wire:model.live.debounce.300ms="search"
                    class="block w-full pl-10 pr-10 py-3 border border-gray-300 dark:border-gray-600 rounded-lg 
                           focus:ring-2 focus:ring-blue-500 focus:border-transparent
                           dark:bg-gray-700 dark:text-white"
                    placeholder="Buscar por número ou assunto..."
                />
                @if($search)
                    <button 
                        wire:click="clearSearch"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                @endif
            </div>
        </div>

        {{-- Status Tabs --}}
        <div class="flex flex-wrap gap-2 mb-4">
            <button 
                wire:click="filterByStatus('all')"
                class="px-4 py-2 rounded-lg text-sm font-medium transition
                    {{ $filterStatus === 'all' ? 'bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-300' : 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
                Todos ({{ $statusCounts['all'] }})
            </button>
            <button 
                wire:click="filterByStatus('open')"
                class="px-4 py-2 rounded-lg text-sm font-medium transition
                    {{ $filterStatus === 'open' ? 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-300' : 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
                Abertos ({{ $statusCounts['open'] }})
            </button>
            <button 
                wire:click="filterByStatus('resolved')"
                class="px-4 py-2 rounded-lg text-sm font-medium transition
                    {{ $filterStatus === 'resolved' ? 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300' : 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
                Resolvidos ({{ $statusCounts['resolved'] }})
            </button>
            <button 
                wire:click="filterByStatus('closed')"
                class="px-4 py-2 rounded-lg text-sm font-medium transition
                    {{ $filterStatus === 'closed' ? 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300' : 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
                Fechados ({{ $statusCounts['closed'] }})
            </button>
        </div>

        {{-- Priority Filter --}}
        <div class="flex flex-wrap gap-2">
            <span class="text-sm text-gray-600 dark:text-gray-400 py-2">Prioridade:</span>
            <button 
                wire:click="filterByPriority('all')"
                class="px-3 py-1 rounded-full text-xs font-medium transition
                    {{ $filterPriority === 'all' ? 'bg-gray-700 text-white dark:bg-gray-600' : 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300 hover:bg-gray-200' }}">
                Todas
            </button>
            <button 
                wire:click="filterByPriority('low')"
                class="px-3 py-1 rounded-full text-xs font-medium transition
                    {{ $filterPriority === 'low' ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300 hover:bg-gray-200' }}">
                Baixa
            </button>
            <button 
                wire:click="filterByPriority('normal')"
                class="px-3 py-1 rounded-full text-xs font-medium transition
                    {{ $filterPriority === 'normal' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300 hover:bg-gray-200' }}">
                Normal
            </button>
            <button 
                wire:click="filterByPriority('high')"
                class="px-3 py-1 rounded-full text-xs font-medium transition
                    {{ $filterPriority === 'high' ? 'bg-orange-600 text-white' : 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300 hover:bg-gray-200' }}">
                Alta
            </button>
            <button 
                wire:click="filterByPriority('urgent')"
                class="px-3 py-1 rounded-full text-xs font-medium transition
                    {{ $filterPriority === 'urgent' ? 'bg-red-600 text-white' : 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300 hover:bg-gray-200' }}">
                Urgente
            </button>
        </div>
    </div>

    {{-- Tickets List --}}
    @if($tickets->count() > 0)
        <div class="space-y-4 mb-6">
            @foreach($tickets as $ticket)
                <div 
                    wire:click="viewTicket({{ $ticket->id }})"
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 hover:shadow-md transition cursor-pointer">
                    
                    <div class="flex items-start justify-between gap-4">
                        {{-- Left Side --}}
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-3 mb-2">
                                {{-- Icon --}}
                                <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                                    </svg>
                                </div>

                                {{-- Title & Number --}}
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-semibold text-gray-900 dark:text-white truncate">
                                        {{ $ticket->subject }}
                                    </h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $ticket->ticket_number }} • 
                                        Aberto {{ $ticket->opened_at->diffForHumans() }}
                                    </p>
                                </div>
                            </div>

                            {{-- Description Preview --}}
                            <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-2 mb-3">
                                {{ $ticket->description }}
                            </p>

                            {{-- Meta Info --}}
                            <div class="flex flex-wrap items-center gap-3 text-sm">
                                {{-- Category --}}
                                @if($ticket->category)
                                    <span class="inline-flex items-center gap-1 text-gray-600 dark:text-gray-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                        </svg>
                                        {{ ucfirst($ticket->category) }}
                                    </span>
                                @endif

                                {{-- Subscription --}}
                                @if($ticket->subscription)
                                    <span class="inline-flex items-center gap-1 text-gray-600 dark:text-gray-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"/>
                                        </svg>
                                        {{ $ticket->subscription->plan->name }}
                                    </span>
                                @endif

                                {{-- Assigned To --}}
                                @if($ticket->assignedTo)
                                    <span class="inline-flex items-center gap-1 text-gray-600 dark:text-gray-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                        {{ $ticket->assignedTo->name }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- Right Side: Badges --}}
                        <div class="flex flex-col items-end gap-2 flex-shrink-0">
                            {{-- Priority Badge --}}
                            <span class="px-3 py-1 text-xs font-semibold rounded-full
                                @if($ticket->priority === 'urgent') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300
                                @elseif($ticket->priority === 'high') bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-300
                                @elseif($ticket->priority === 'normal') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300
                                @else bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                                @endif">
                                {{ ucfirst($ticket->priority) }}
                            </span>

                            {{-- Status Badge --}}
                            <span class="px-3 py-1 text-xs font-semibold rounded-full
                                @if($ticket->status === 'open') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300
                                @elseif($ticket->status === 'in_progress') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300
                                @elseif($ticket->status === 'waiting_customer') bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300
                                @elseif($ticket->status === 'resolved') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                                @elseif($ticket->status === 'closed') bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300
                                @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300
                                @endif">
                                @if($ticket->status === 'open') Aberto
                                @elseif($ticket->status === 'in_progress') Em Andamento
                                @elseif($ticket->status === 'waiting_customer') Aguardando
                                @elseif($ticket->status === 'resolved') Resolvido
                                @elseif($ticket->status === 'closed') Fechado
                                @else {{ ucfirst($ticket->status) }}
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $tickets->links() }}
        </div>

    @else
        {{-- Empty State --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-16 text-center">
            <div class="w-20 h-20 mx-auto bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-4">
                <svg class="w-10 h-10 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                Nenhum ticket encontrado
            </h3>
            <p class="text-gray-600 dark:text-gray-400 mb-6">
                @if($search || $filterStatus !== 'all' || $filterPriority !== 'all')
                    Tente ajustar seus filtros de busca
                @else
                    Você ainda não tem tickets de suporte
                @endif
            </p>
            @if(!$search && $filterStatus === 'all')
                <a href="{{ route('customer.tickets.create') }}" 
                   wire:navigate
                   class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Abrir Primeiro Ticket
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