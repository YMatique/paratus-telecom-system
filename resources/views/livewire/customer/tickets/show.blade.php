<div class="max-w-4xl mx-auto">
    {{-- Header --}}
    <div class="mb-8">
        <div class="flex items-start justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                    {{ $ticket->subject }}
                </h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    {{ $ticket->ticket_number }} • Aberto {{ $ticket->opened_at->diffForHumans() }}
                </p>
            </div>

            <div class="flex gap-2">
                @if($this->canReopen)
                    <button 
                        wire:click="reopenTicket" 
                        wire:confirm="Tem certeza que deseja reabrir este ticket?"
                        class="px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white text-sm font-medium rounded-lg transition">
                        Reabrir Ticket
                    </button>
                @endif

                <a href="{{ route('customer.tickets.index') }}" wire:navigate
                   class="px-4 py-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-lg transition">
                    Voltar
                </a>
            </div>
        </div>
    </div>

    {{-- Ticket Info Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
        <div class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-700">
            <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Prioridade</p>
            <p class="mt-1 text-lg font-semibold" 
                style="color: {{ \Str::startsWith($ticket->priority_color, '#') ? $ticket->priority_color : '' }}">
                <span class="inline-block w-3 h-3 rounded-full mr-2"
                      style="background-color: {{ $ticket->priority === 'urgent' ? '#ef4444' : ($ticket->priority === 'high' ? '#f97316' : ($ticket->priority === 'medium' ? '#3b82f6' : '#10b981')) }}">
                </span>
                {{ $ticket->priority_label }}
            </p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-700">
            <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Status</p>
            <p class="mt-1 text-lg font-semibold">
                <span class="px-3 py-1 text-xs font-semibold rounded-full
                    {{ $ticket->status === 'open' ? 'bg-yellow-100 text-yellow-800' : 
                       ($ticket->status === 'in_progress' ? 'bg-blue-100 text-blue-800' : 
                       ($ticket->status === 'waiting_customer' ? 'bg-purple-100 text-purple-800' : 
                       ($ticket->status === 'resolved' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'))) }}">
                    {{ $ticket->status_label }}
                </span>
            </p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-700">
            <p class="text-xs font-medium text-gray-500 dark:text-gray-400">SLA</p>
            <p class="mt-1 text-lg font-semibold">
                <span class="inline-block w-3 h-3 rounded-full mr-2"
                      style="background-color: {{ $ticket->sla_status_color === 'green' ? '#10b981' : ($ticket->sla_status_color === 'yellow' ? '#f59e0b' : ($ticket->sla_status_color === 'red' ? '#ef4444' : '#6b7280')) }}">
                </span>
                {{ ucfirst(str_replace('_', ' ', $ticket->getSlaStatus())) }}
            </p>
        </div>
    </div>

    {{-- Description --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-700 mb-8">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Descrição</h3>
        <p class="text-gray-700 dark:text-gray-300 whitespace-pre-wrap">{{ $ticket->description }}</p>
    </div>

    {{-- Responses Timeline --}}
    <div class="space-y-6 mb-8">
        @foreach($this->responses as $response)
            <div class="flex gap-4">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center text-blue-600 dark:text-blue-400 font-semibold text-sm">
                        {{ substr(optional($response->user)->name ?? 'Você', 0, 1) }}
                    </div>
                </div>
                <div class="flex-1 bg-white dark:bg-gray-800 rounded-xl p-5 border border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between mb-2">
                        <p class="font-medium text-gray-900 dark:text-white">
                            {{ $response->user?->name ?? 'Você' }}
                        </p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            {{ $response->created_at->diffForHumans() }}
                        </p>
                    </div>
                    <p class="text-gray-700 dark:text-gray-300 whitespace-pre-wrap mb-3">{{ $response->response }}</p>

                    @if($response->hasAttachments())
                        <div class="flex flex-wrap gap-2">
                            @foreach($response->attachments as $index => $file)
                                <a href="{{ route('customer.tickets.attachment', [$ticket->id, $loop->parent->index, $index]) }}"
                                   class="inline-flex items-center gap-2 px-3 py-1 bg-gray-100 dark:bg-gray-700 rounded-lg text-xs text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                                    </svg>
                                    {{ $file['name'] }}
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    {{-- Reply Box --}}
    @if($this->canRespond)
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Enviar Resposta</h3>
            <form wire:submit="sendResponse">
                <textarea 
                    wire:model="response" 
                    rows="4" 
                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white"
                    placeholder="Escreva sua resposta aqui..."></textarea>

                <div class="mt-4 flex items-center justify-between">
                    <input 
                        type="file" 
                        wire:model="attachments" 
                        multiple 
                        class="text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                    />

                    <button 
                        type="submit" 
                        wire:loading.attr="disabled"
                        class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition disabled:opacity-50">
                        <span wire:loading.remove>Enviar</span>
                        <span wire:loading>Enviando...</span>
                    </button>
                </div>
            </form>
        </div>
    @else
        <div class="bg-gray-50 dark:bg-gray-800 rounded-xl p-6 text-center text-gray-600 dark:text-gray-400">
            <p>Este ticket está {{ $ticket->status === 'resolved' ? 'resolvido' : 'fechado' }}. Não é possível adicionar mais respostas.</p>
            @if($canReopen)
                <button wire:click="reopenTicket" class="mt-3 text-blue-600 hover:underline">
                    Clique aqui para reabrir
                </button>
            @endif
        </div>
    @endif
</div>

{{-- Notifications --}}
@push('scripts')
<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('response-sent', () => {
            Notyf.success('Resposta enviada com sucesso!');
        });
        Livewire.on('ticket-reopened', () => {
            Notyf.success('Ticket reaberto com sucesso!');
        });
    });
</script>
@endpush