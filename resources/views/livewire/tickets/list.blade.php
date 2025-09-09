{{-- Filtros e Busca --}}
<div class="bg-white dark:bg-gray-800 rounded-lg p-6 border border-gray-200 dark:border-gray-700 mb-6">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-4 mb-4">
        {{-- Busca --}}
        <div class="lg:col-span-2">
            <input wire:model.live="search" type="text" placeholder="Buscar tickets..."
                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
        </div>

        {{-- Filtro Status --}}
        <div>
            <select wire:model.live="filterStatus"
                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                <option value="all">Todos os Status</option>
                <option value="open">Abertos</option>
                <option value="in_progress">Em Progresso</option>
                <option value="waiting_customer">Aguardando Cliente</option>
                <option value="resolved">Resolvidos</option>
                <option value="closed">Fechados</option>
            </select>
        </div>

        {{-- Filtro Prioridade --}}
        <div>
            <select wire:model.live="filterPriority"
                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                <option value="all">Todas as Prioridades</option>
                <option value="urgent">Urgente</option>
                <option value="high">Alta</option>
                <option value="medium">Média</option>
                <option value="low">Baixa</option>
            </select>
        </div>

        {{-- Filtro Categoria --}}
        <div>
            <select wire:model.live="filterCategory"
                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                <option value="all">Todas as Categorias</option>
                <option value="technical">Técnico</option>
                <option value="billing">Faturamento</option>
                <option value="installation">Instalação</option>
                <option value="complaint">Reclamação</option>
                <option value="request">Solicitação</option>
            </select>
        </div>

        {{-- Filtro Atribuição --}}
        <div>
            <select wire:model.live="filterAssigned"
                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                <option value="all">Todos</option>
                <option value="me">Meus Tickets</option>
                <option value="unassigned">Não Atribuídos</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- Ações em Massa --}}
    @if (!empty($selectedTickets))
        <div class="flex items-center justify-between mb-4 p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
            <span class="text-sm text-blue-700 dark:text-blue-300">
                {{ count($selectedTickets) }} ticket(s) selecionado(s)
            </span>
            <div class="flex space-x-2">
                <select wire:model="bulkAction" class="px-3 py-1 text-sm border border-gray-300 rounded">
                    <option value="">Selecionar ação...</option>
                    <option value="assign_me">Atribuir para mim</option>
                    <option value="mark_resolved">Marcar como resolvido</option>
                    <option value="mark_closed">Fechar tickets</option>
                </select>
                <button wire:click="executeBulkAction"
                    class="px-3 py-1 text-sm bg-blue-600 text-white rounded hover:bg-blue-700">
                    Executar
                </button>
            </div>
        </div>
    @endif
</div>

{{-- Tabela de Tickets --}}
<div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left">
                        <input type="checkbox" wire:model="selectAll"
                            class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    </th>
                    <th
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                        Ticket
                    </th>
                    <th
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                        Cliente
                    </th>
                    <th
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                        Assunto
                    </th>
                    <th
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                        Prioridade
                    </th>
                    <th
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                        Status
                    </th>
                    <th
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                        Atribuído
                    </th>
                    <th
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                        SLA
                    </th>
                    <th
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider w-32">
                        Ações
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($tickets as $ticket)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-6 py-4">
                            <input type="checkbox" wire:model="selectedTickets" value="{{ $ticket->id }}"
                                class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div>
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                        #{{ $ticket->ticket_number }}
                                    </div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $ticket->category_label }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900 dark:text-white">{{ $ticket->customer->name }}</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ $ticket->customer->document }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900 dark:text-white">
                                {{ Str::limit($ticket->subject, 50) }}
                            </div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                {{ $ticket->created_at->diffForHumans() }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span
                                class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                {{ $ticket->priority === 'urgent'
                                    ? 'bg-red-100 text-red-800'
                                    : ($ticket->priority === 'high'
                                        ? 'bg-orange-100 text-orange-800'
                                        : ($ticket->priority === 'medium'
                                            ? 'bg-yellow-100 text-yellow-800'
                                            : 'bg-green-100 text-green-800')) }}">
                                {{ $ticket->priority_label }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span
                                class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                {{ $ticket->status === 'open'
                                    ? 'bg-red-100 text-red-800'
                                    : ($ticket->status === 'in_progress'
                                        ? 'bg-blue-100 text-blue-800'
                                        : ($ticket->status === 'waiting_customer'
                                            ? 'bg-yellow-100 text-yellow-800'
                                            : ($ticket->status === 'resolved'
                                                ? 'bg-green-100 text-green-800'
                                                : 'bg-gray-100 text-gray-800'))) }}">
                                {{ $ticket->status_label }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">
                            @if ($ticket->assignedTo)
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-6 w-6">
                                        <div class="h-6 w-6 rounded-full bg-blue-100 flex items-center justify-center">
                                            <span class="text-xs font-medium text-blue-800">
                                                {{ substr($ticket->assignedTo->name, 0, 1) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="ml-2">
                                        <div class="text-sm text-gray-900 dark:text-white">
                                            {{ $ticket->assignedTo->name }}</div>
                                    </div>
                                </div>
                            @else
                                <span class="text-gray-400">Não atribuído</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span
                                class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                {{ $ticket->sla_status_color === 'green'
                                    ? 'bg-green-100 text-green-800'
                                    : ($ticket->sla_status_color === 'yellow'
                                        ? 'bg-yellow-100 text-yellow-800'
                                        : ($ticket->sla_status_color === 'red'
                                            ? 'bg-red-100 text-red-800'
                                            : 'bg-blue-100 text-blue-800')) }}">
                                {{ ucfirst($ticket->getSlaStatus()) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm font-medium space-x-2">
                            <button wire:click="viewTicket({{ $ticket->id }})"
                                class="text-blue-600 hover:text-blue-900 dark:text-blue-400 p-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                    </path>
                                </svg>
                            </button>
                            <button wire:click="editTicket({{ $ticket->id }})"
                                class="text-green-600 hover:text-green-900 dark:text-green-400 p-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                    </path>
                                </svg>
                            </button>
                            @if ($ticket->isOpen())
                                <button wire:click="changeStatus({{ $ticket->id }}, 'resolved')"
                                    class="text-purple-600 hover:text-purple-900 dark:text-purple-400 p-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </button>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                            <div class="flex flex-col items-center">
                                <svg class="w-12 h-12 text-gray-300 mb-4" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                    </path>
                                </svg>
                                <p class="text-lg font-medium">Nenhum ticket encontrado</p>
                                <p class="mt-1">Crie o primeiro ticket para começar</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Paginação --}}
    @if ($tickets->hasPages())
        <div class="px-6 py-3 border-t border-gray-200 dark:border-gray-700">
            {{ $tickets->links() }}
        </div>
    @endif
</div>
