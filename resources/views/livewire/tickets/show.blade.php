{{-- Visualização do Ticket --}}
<div class="space-y-6">
    {{-- Header do Ticket --}}
    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 border border-gray-200 dark:border-gray-700">
        <div class="flex items-start justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                    #{{ $selectedTicket->ticket_number }}
                </h2>
                <p class="text-lg text-gray-600 dark:text-gray-400 mt-1">
                    {{ $selectedTicket->subject }}
                </p>
                <div class="flex items-center space-x-4 mt-3">
                    <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full 
                        {{ 'bg-' . $selectedTicket->priority_color . '-100 text-' . $selectedTicket->priority_color . '-800' }}">
                        {{ $selectedTicket->priority_label }}
                    </span>
                    <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full 
                        {{ 'bg-' . $selectedTicket->status_color . '-100 text-' . $selectedTicket->status_color . '-800' }}">
                        {{ $selectedTicket->status_label }}
                    </span>
                    <span class="text-sm text-gray-500">
                        {{ $selectedTicket->category_label }}
                    </span>
                </div>
            </div>
            <div class="flex space-x-2">
                @if($selectedTicket->isOpen())
                    <button wire:click="changeStatus({{ $selectedTicket->id }}, 'resolved')" 
                        class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                        Marcar como Resolvido
                    </button>
                @endif
                <button wire:click="$set('showResponseModal', true)" 
                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    Adicionar Resposta
                </button>
                <button wire:click="editTicket({{ $selectedTicket->id }})" 
                    class="px-4 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700">
                    Editar
                </button>
            </div>
        </div>
    </div>

    {{-- Conteúdo Principal --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Detalhes do Ticket --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Descrição Original --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 border border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-3">Descrição</h3>
                <div class="text-gray-700 dark:text-gray-300 whitespace-pre-line">
                    {{ $selectedTicket->description }}
                </div>
                <div class="mt-4 text-sm text-gray-500">
                    Criado em {{ $selectedTicket->created_at->format('d/m/Y H:i') }}
                </div>
            </div>

            {{-- Respostas --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 border border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">
                    Respostas ({{ $selectedTicket->responses->count() }})
                </h3>
                
                @forelse($selectedTicket->responses as $response)
                    <div class="border-l-4 pl-4 mb-6 
                        {{ $response->is_internal ? 'border-yellow-400' : 'border-blue-400' }}">
                        <div class="flex items-start justify-between">
                            <div class="flex items-center space-x-2">
                                <span class="font-medium text-gray-900 dark:text-white">
                                    {{ $response->user->name }}
                                </span>
                                @if($response->is_internal)
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded bg-yellow-100 text-yellow-800">
                                        Nota Interna
                                    </span>
                                @endif
                                @if($response->is_solution)
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded bg-green-100 text-green-800">
                                        Solução
                                    </span>
                                @endif
                            </div>
                            <span class="text-sm text-gray-500">
                                {{ $response->created_at->diffForHumans() }}
                            </span>
                        </div>
                        <div class="mt-2 text-gray-700 dark:text-gray-300 whitespace-pre-line">
                            {{ $response->response }}
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4">Nenhuma resposta ainda.</p>
                @endforelse
            </div>
        </div>

        {{-- Sidebar com informações --}}
        <div class="space-y-6">
            {{-- Cliente --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 border border-gray-200 dark:border-gray-700">
                <h4 class="font-medium text-gray-900 dark:text-white mb-3">Cliente</h4>
                <div class="space-y-2">
                    <div>
                        <span class="text-sm text-gray-500">Nome:</span>
                        <p class="font-medium">{{ $selectedTicket->customer->name }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-gray-500">Documento:</span>
                        <p>{{ $selectedTicket->customer->document }}</p>
                    </div>
                    @if($selectedTicket->customer->email)
                    <div>
                        <span class="text-sm text-gray-500">Email:</span>
                        <p>{{ $selectedTicket->customer->email }}</p>
                    </div>
                    @endif
                    @if($selectedTicket->customer->phone)
                    <div>
                        <span class="text-sm text-gray-500">Telefone:</span>
                        <p>{{ $selectedTicket->customer->phone }}</p>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Atribuição --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 border border-gray-200 dark:border-gray-700">
                <h4 class="font-medium text-gray-900 dark:text-white mb-3">Atribuição</h4>
                @if($selectedTicket->assignedTo)
                    <div class="flex items-center space-x-3">
                        <div class="flex-shrink-0 h-8 w-8">
                            <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center">
                                <span class="text-sm font-medium text-blue-800">
                                    {{ substr($selectedTicket->assignedTo->name, 0, 1) }}
                                </span>
                            </div>
                        </div>
                        <div>
                            <p class="font-medium">{{ $selectedTicket->assignedTo->name }}</p>
                            <p class="text-sm text-gray-500">{{ $selectedTicket->assignedTo->email }}</p>
                        </div>
                    </div>
                    <button wire:click="assignTicket({{ $selectedTicket->id }}, null)" 
                        class="mt-3 text-sm text-red-600 hover:text-red-800">
                        Remover atribuição
                    </button>
                @else
                    <p class="text-gray-500 mb-3">Não atribuído</p>
                    <select wire:change="assignTicket({{ $selectedTicket->id }}, $event.target.value)" 
                        class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700">
                        <option value="">Atribuir para...</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                @endif
            </div>

            {{-- SLA e Tempos --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 border border-gray-200 dark:border-gray-700">
                <h4 class="font-medium text-gray-900 dark:text-white mb-3">SLA e Tempos</h4>
                <div class="space-y-3">
                    <div>
                        <span class="text-sm text-gray-500">Status SLA:</span>
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full ml-2
                            {{ 'bg-' . $selectedTicket->sla_status_color . '-100 text-' . $selectedTicket->sla_status_color . '-800' }}">
                            {{ ucfirst($selectedTicket->getSlaStatus()) }}
                        </span>
                    </div>
                    <div>
                        <span class="text-sm text-gray-500">Aberto há:</span>
                        <p>{{ $selectedTicket->opened_at->diffForHumans() }}</p>
                    </div>
                    @if($selectedTicket->resolved_at)
                    <div>
                        <span class="text-sm text-gray-500">Resolvido em:</span>
                        <p>{{ $selectedTicket->response_time }}h</p>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Subscrição --}}
            @if($selectedTicket->subscription)
            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 border border-gray-200 dark:border-gray-700">
                <h4 class="font-medium text-gray-900 dark:text-white mb-3">Subscrição</h4>
                <div class="space-y-2">
                    <div>
                        <span class="text-sm text-gray-500">Plano:</span>
                        <p class="font-medium">{{ $selectedTicket->subscription->plan->name }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-gray-500">Velocidade:</span>
                        <p>{{ $selectedTicket->subscription->plan->download_speed }}MB / {{ $selectedTicket->subscription->plan->upload_speed }}MB</p>
                    </div>
                    <div>
                        <span class="text-sm text-gray-500">Status:</span>
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full ml-1
                            {{ $selectedTicket->subscription->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ ucfirst($selectedTicket->subscription->status) }}
                        </span>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>