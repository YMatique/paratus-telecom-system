<div class=" mx-auto p-4 md:p-6">
    {{-- Header com Status & Ações --}}
    <div class="mb-8 bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
        <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
            <div class="flex-1">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center text-white font-bold text-sm"
                         style="background-color: {{ $ticket->priority === 'urgent' ? '#ef4444' : ($ticket->priority === 'high' ? '#f97316' : ($ticket->priority === 'medium' ? '#3b82f6' : '#10b981')) }}">
                        {{ strtoupper(substr($ticket->priority, 0, 1)) }}
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $ticket->subject }}</h1>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            <span class="font-mono">{{ $ticket->ticket_number }}</span> • 
                            Aberto {{ $ticket->opened_at->diffForHumans() }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="flex gap-2">
                @if($this->canReopen)
                    <button 
                        wire:click="reopenTicket" 
                        wire:confirm="Tem certeza que deseja reabrir este ticket?"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-medium rounded-xl transition-all shadow-sm hover:shadow">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0L9 4m-4.418 5H9m11 6v5h-.582m-15.356 2A8.001 8.001 0 0115.418 15m0 0L11 20m4.418-5H11"/>
                        </svg>
                        Reabrir
                    </button>
                @endif

                <a href="{{ route('customer.tickets.index') }}" wire:navigate
                   class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-xl transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Voltar
                </a>
            </div>
        </div>
    </div>

    {{-- Info Cards com SLA Progress --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
        {{-- Prioridade --}}
        <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl p-5 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Prioridade</p>
                    <p class="mt-1 text-lg font-bold text-gray-900 dark:text-white">{{ $ticket->priority_label }}</p>
                </div>
                <div class="w-12 h-12 rounded-full flex items-center justify-center"
                     style="background-color: {{ $ticket->priority === 'urgent' ? '#fee2e2' : ($ticket->priority === 'high' ? '#fed7aa' : ($ticket->priority === 'medium' ? '#bfdbfe' : '#d1fae5')) }}">
                    <svg class="w-6 h-6 {{ $ticket->priority === 'urgent' ? 'text-red-600' : ($ticket->priority === 'high' ? 'text-orange-600' : ($ticket->priority === 'medium' ? 'text-blue-600' : 'text-green-600')) }}" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- Status --}}
        <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl p-5 border border-gray-200 dark:border-gray-700">
            <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</p>
            <div class="mt-2">
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold
                    {{ $ticket->status === 'open' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300' : 
                       ($ticket->status === 'in_progress' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300' : 
                       ($ticket->status === 'waiting_customer' ? 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300' : 
                       ($ticket->status === 'resolved' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300'))) }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ $ticket->status === 'open' ? 'bg-yellow-600' : ($ticket->status === 'in_progress' ? 'bg-blue-600' : ($ticket->status === 'waiting_customer' ? 'bg-purple-600' : ($ticket->status === 'resolved' ? 'bg-green-600' : 'bg-gray-600'))) }}"></span>
                    {{ $ticket->status_label }}
                </span>
            </div>
        </div>

        {{-- SLA com Barra --}}
        <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl p-5 border border-gray-200 dark:border-gray-700">
            <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">SLA</p>
            <div class="mt-2">
                <div class="flex items-center justify-between text-sm font-medium mb-1">
                    <span class="{{ $ticket->getSlaStatus() === 'breached' ? 'text-red-600' : ($ticket->getSlaStatus() === 'warning' ? 'text-amber-600' : 'text-green-600') }}">
                        {{ ucfirst(str_replace('_', ' ', $ticket->getSlaStatus())) }}
                    </span>
                    @if($ticket->response_time)
                        <span class="text-gray-500">{{ $ticket->response_time }}h</span>
                    @endif
                </div>
                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                    <div class="h-2 rounded-full transition-all duration-500"
                         style="width: {{ $ticket->getSlaStatus() === 'breached' ? '100%' : ($ticket->getSlaStatus() === 'warning' ? '85%' : '60%') }};
                                background-color: {{ $ticket->getSlaStatus() === 'breached' ? '#ef4444' : ($ticket->getSlaStatus() === 'warning' ? '#f59e0b' : '#10b981') }}">
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Descrição --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-8">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3 flex items-center gap-2">
            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
            </svg>
            Descrição
        </h3>
        <div class="prose prose-sm dark:prose-invert max-w-none text-gray-700 dark:text-gray-300">
            {!! nl2br(e($ticket->description)) !!}
        </div>
    </div>

    {{-- Timeline de Respostas --}}
    <div class="space-y-8 mb-8">
        @forelse($this->responses as $index => $response)
            <div class="relative flex gap-4">
                {{-- Linha vertical (exceto último) --}}
                @if(!$loop->last)
                    <div class="absolute left-5 top-12 bottom-0 w-0.5 bg-gray-200 dark:bg-gray-700"></div>
                @endif

                {{-- Avatar --}}
                <div class="relative z-10 flex-shrink-0">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center text-white font-bold text-sm shadow-sm
                                {{ $response->user ? 'bg-gradient-to-br from-blue-500 to-blue-600' : 'bg-gradient-to-br from-emerald-500 to-emerald-600' }}">
                        {{ substr($response->user?->name ?? 'Você', 0, 1) }}
                    </div>
                </div>

                {{-- Card da Resposta --}}
                <div class="flex-1 bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center gap-2">
                            <p class="font-semibold text-gray-900 dark:text-white">
                                {{ $response->user?->name ?? 'Você' }}
                            </p>
                            @if(!$response->user)
                                <span class="text-xs font-medium text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-900/30 px-2 py-0.5 rounded-full">Cliente</span>
                            @endif
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            {{ $response->created_at->format('d/m/Y H:i') }}
                        </p>
                    </div>

                    <div class="prose prose-sm dark:prose-invert max-w-none text-gray-700 dark:text-gray-300 mb-4">
                        {!! nl2br(e($response->response)) !!}
                    </div>

                    @if($response->hasAttachments())
                        <div class="flex flex-wrap gap-2">
                            @foreach($response->attachments as $fileIndex => $file)
                                @php
                                    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                                    $icon = match(strtolower($ext)) {
                                        'pdf' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
                                        'jpg', 'jpeg', 'png', 'gif' => 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z',
                                        'doc', 'docx' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
                                        default => 'M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13'
                                    };
                                @endphp
                                <a href="{{ route('customer.tickets.attachment', [$ticket->id, $index, $fileIndex]) }}"
                                   class="group inline-flex items-center gap-2 px-3 py-2 bg-gray-50 dark:bg-gray-700 rounded-xl text-xs font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600 transition-all">
                                    <svg class="w-4 h-4 text-gray-500 group-hover:text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"/>
                                    </svg>
                                    <span class="truncate max-w-32">{{ $file['name'] }}</span>
                                    <svg class="w-3 h-3 text-gray-400 group-hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                    </svg>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="text-center py-12 text-gray-500 dark:text-gray-400">
                <svg class="w-16 h-16 mx-auto mb-3 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                </svg>
                <p>Nenhuma resposta ainda.</p>
            </div>
        @endforelse
    </div>

    {{-- Caixa de Resposta --}}
    @if($this->canRespond)
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                Enviar Resposta
            </h3>
            <form wire:submit="sendResponse" class="space-y-4">
                <div>
                    <textarea 
                        wire:model="response" 
                        rows="5" 
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-all resize-none"
                        placeholder="Escreva sua resposta aqui..."></textarea>
                    @error('response') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <input 
                        type="file" 
                        wire:model="attachments" 
                        multiple 
                        class="text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-blue-900 dark:file:text-blue-300"
                    />

                    <button 
                        type="submit" 
                        wire:loading.attr="disabled"
                        class="inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-xl transition-all disabled:opacity-50 disabled:cursor-not-allowed shadow-sm hover:shadow">
                        <span wire:loading.remove>Enviar Resposta</span>
                        <span wire:loading>Enviando...</span>
                        <svg wire:loading class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    @else
        <div class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-900 rounded-2xl p-8 text-center">
            <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
            <p class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-2">
                Este ticket está <span class="font-bold text-gray-900 dark:text-white">{{ $ticket->status === 'resolved' ? 'resolvido' : 'fechado' }}</span>
            </p>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Não é possível adicionar mais respostas.
            </p>
            @if($this->canReopen)
                <button wire:click="reopenTicket" class="mt-4 text-blue-600 hover:text-blue-700 font-medium underline">
                    Clique aqui para reabrir
                </button>
            @endif
        </div>
    @endif
</div>

{{-- Notificações --}}
@push('scripts')
<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('response-sent', () => {
            new Notyf().success({
                message: 'Resposta enviada com sucesso!',
                duration: 3000,
                position: { x: 'right', y: 'top' }
            });
        });
        Livewire.on('ticket-reopened', () => {
            new Notyf().success({
                message: 'Ticket reaberto com sucesso!',
                duration: 3000
            });
        });
    });
</script>
@endpush