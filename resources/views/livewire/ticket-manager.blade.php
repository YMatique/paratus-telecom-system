<div class="space-y-6">
    {{-- Header com Estatísticas --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-4">
        <div class="bg-white dark:bg-gray-800 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-2 rounded-full bg-red-100 dark:bg-red-900/20">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Abertos</p>
                    <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $stats['total_open'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-2 rounded-full bg-orange-100 dark:bg-orange-900/20">
                    <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Urgentes</p>
                    <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $stats['total_urgent'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-2 rounded-full bg-blue-100 dark:bg-blue-900/20">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Meus Tickets</p>
                    <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $stats['my_tickets'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-2 rounded-full bg-gray-100 dark:bg-gray-900/20">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Não Atribuídos</p>
                    <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $stats['unassigned'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-2 rounded-full bg-green-100 dark:bg-green-900/20">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Resolvidos Hoje</p>
                    <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $stats['resolved_today'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-2 rounded-full bg-purple-100 dark:bg-purple-900/20">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Tempo Médio</p>
                    <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $stats['avg_response_time'] }}h</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Navegação por Tabs --}}
    <div class="border-b border-gray-200 dark:border-gray-700">
        <nav class="-mb-px flex space-x-8">
            <button wire:click="$set('activeTab', 'list')" 
                class="py-2 px-1 border-b-2 font-medium text-sm {{ $activeTab === 'list' ? 
                'border-blue-500 text-blue-600' : 
                'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                Lista de Tickets
            </button>
            <button wire:click="createTicket" 
                class="py-2 px-1 border-b-2 font-medium text-sm {{ $activeTab === 'create' ? 
                'border-blue-500 text-blue-600' : 
                'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                {{ $selectedTicket ? 'Editar Ticket' : 'Novo Ticket' }}
            </button>
            @if($selectedTicket)
            <button wire:click="viewTicket({{ $selectedTicket->id }})" 
                class="py-2 px-1 border-b-2 font-medium text-sm {{ $activeTab === 'view' ? 
                'border-blue-500 text-blue-600' : 
                'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                Ver: #{{ $selectedTicket->ticket_number }}
            </button>
            @endif
        </nav>
    </div>

    {{-- Conteúdo Principal --}}
    @if($activeTab === 'list')
        @include('livewire.tickets.list')
    @elseif($activeTab === 'create')
        @include('livewire.tickets.form')
    @elseif($activeTab === 'view' && $selectedTicket)
        @include('livewire.tickets.show')
    @endif

    {{-- Modal de Resposta --}}
    @if($showResponseModal)
        @include('livewire.tickets.response-modal')
    @endif

    {{-- Loading State --}}
    <div wire:loading class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white dark:bg-gray-800 rounded-lg p-6 flex items-center">
            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span class="text-gray-700 dark:text-gray-300">Processando...</span>
        </div>
    </div>
</div>