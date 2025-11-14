<div class="flex items-start justify-between gap-4">
    <div class="flex-1 min-w-0">
        <div class="flex items-center gap-3 mb-2">
            <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
            </div>
            <div class="flex-1 min-w-0">
                <h3 class="font-semibold text-gray-900 dark:text-white truncate">{{ $ticket->subject }}</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    {{ $ticket->ticket_number }} • {{ $ticket->opened_at->diffForHumans() }}
                </p>
            </div>
        </div>
        <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-2 mb-3">{{ $ticket->description }}</p>
        <div class="flex flex-wrap items-center gap-3 text-sm">
            @if($ticket->category)
                <span class="inline-flex items-center gap-1 text-gray-600 dark:text-gray-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                    {{ ucfirst($ticket->category) }}
                </span>
            @endif
            @if($ticket->subscription)
                <span class="inline-flex items-center gap-1 text-gray-600 dark:text-gray-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"/>
                    </svg>
                    {{ $ticket->subscription->plan->name }}
                </span>
            @endif
        </div>
    </div>
    <div class="flex flex-col items-end gap-2">
        <span class="px-3 py-1 text-xs font-semibold rounded-full
            @if($ticket->priority === 'urgent') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300
            @elseif($ticket->priority === 'high') bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-300
            @elseif($ticket->priority === 'normal') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300
            @else bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
            @endif">
            {{ ucfirst($ticket->priority) }}
        </span>
        <span class="px-3 py-1 text-xs font-semibold rounded-full
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
    </div>
</div>