<div>
    {{-- Page Header --}}
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Meus Tickets</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">
                Gerencie suas solicitações de suporte
            </p>
        </div>

        <div class="flex items-center gap-3">
            {{-- View Mode Toggle --}}
            <div class="flex items-center bg-gray-100 dark:bg-gray-700 rounded-lg p-1">
                <button 
                    wire:click="setViewMode('cards')"
                    class="flex items-center gap-2 px-3 py-1.5 rounded-md text-sm font-medium transition
                           {{ $viewMode === 'cards' ? 'bg-white dark:bg-gray-800 text-blue-600 shadow-sm' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                    </svg>
                    Cards
                </button>
                <button 
                    wire:click="setViewMode('list')"
                    class="flex items-center gap-2 px-3 py-1.5 rounded-md text-sm font-medium transition
                           {{ $viewMode === 'list' ? 'bg-white dark:bg-gray-800 text-blue-600 shadow-sm' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    Lista
                </button>
            </div>

            {{-- Novo Ticket --}}
            <a href="{{ route('customer.tickets.create') }}" 
               wire:navigate
               class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition shadow-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Novo Ticket
            </a>
        </div>
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

        @if($viewMode === 'cards')
            {{-- MODO CARDS --}}
            <div class="space-y-4 mb-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($tickets as $ticket)
                    <div 
                        wire:click="viewTicket({{ $ticket->id }})"
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 highlight:border-gray-700 p-6 hover:shadow-md transition cursor-pointer">
                        @include('livewire.customer.tickets.partials.card', ['ticket' => $ticket])
                    </div>
                @endforeach
            </div>

        @else
            {{-- MODO LISTA --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                <table class="w-full">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Ticket</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Categoria</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Prioridade</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Aberto</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($tickets as $ticket)
                            <tr 
                                wire:click="viewTicket({{ $ticket->id }})"
                                class="hover:bg-gray-50 dark:hover:bg-gray-700/50 cursor-pointer transition">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $ticket->subject }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $ticket->ticket_number }}</p>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">
                                    {{ ucfirst($ticket->category) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs font-medium rounded-full
                                        @if($ticket->priority === 'urgent') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300
                                        @elseif($ticket->priority === 'high') bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-300
                                        @elseif($ticket->priority === 'normal') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300
                                        @else bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                                        @endif">
                                        {{ ucfirst($ticket->priority) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs font-medium rounded-full
                                        @if($ticket->status === 'open') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300
                                        @elseif($ticket->status === 'in_progress') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300
                                        @elseif($ticket->status === 'resolved') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                                        @elseif($ticket->status === 'closed') bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300
                                        @endif">
                                        @if($ticket->status === 'open') Aberto
                                        @elseif($ticket->status === 'in_progress') Em Andamento
                                        @elseif($ticket->status === 'resolved') Resolvido
                                        @elseif($ticket->status === 'closed') Fechado
                                        @else {{ ucfirst($ticket->status) }}
                                        @endif
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    {{ $ticket->opened_at->format('d/m/Y') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

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