<div>
    {{-- Breadcrumb --}}
    <nav class="flex mb-6" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('customer.tickets.index') }}" 
                   wire:navigate
                   class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                    Tickets
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-3 h-3 text-gray-400 mx-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">
                        Abrir Ticket
                    </span>
                </div>
            </li>
        </ol>
    </nav>

    {{-- Page Header --}}
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Abrir Novo Ticket</h1>
        <p class="mt-2 text-gray-600 dark:text-gray-400">
            Descreva seu problema ou solicitação e nossa equipe responderá em breve
        </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- Form --}}
        <div class="lg:col-span-2">
            <form wire:submit="createTicket" class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 space-y-6">
                
                {{-- Assunto --}}
                <div>
                    <label for="subject" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Assunto <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="subject"
                        wire:model="subject"
                        class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg 
                               focus:ring-2 focus:ring-blue-500 focus:border-transparent
                               dark:bg-gray-700 dark:text-white
                               @error('subject') border-red-500 @enderror"
                        placeholder="Ex: Internet lenta, Problema de conexão..."
                        maxlength="200"
                    />
                    @error('subject')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @else
                        <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                            {{ strlen($subject) }}/200 caracteres
                        </p>
                    @enderror
                </div>

                {{-- Categoria --}}
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Categoria <span class="text-red-500">*</span>
                    </label>
                    <select 
                        id="category"
                        wire:model="category"
                        class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg 
                               focus:ring-2 focus:ring-blue-500 focus:border-transparent
                               dark:bg-gray-700 dark:text-white
                               @error('category') border-red-500 @enderror">
                        <option value="general">Geral</option>
                        <option value="technical">Problema Técnico</option>
                        <option value="billing">Faturamento</option>
                        <option value="upgrade">Upgrade de Plano</option>
                        <option value="complaint">Reclamação</option>
                    </select>
                    @error('category')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Prioridade --}}
                <div>
                    <label for="priority" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Prioridade <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                        <label class="relative flex items-center p-4 border-2 rounded-lg cursor-pointer transition
                            {{ $priority === 'low' ? 'border-green-500 bg-green-50 dark:bg-green-900/20' : 'border-gray-300 dark:border-gray-600 hover:border-gray-400' }}">
                            <input 
                                type="radio" 
                                wire:model="priority" 
                                value="low"
                                class="sr-only"
                            />
                            <div class="text-center w-full">
                                <div class="text-2xl mb-1">🟢</div>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">Baixa</p>
                            </div>
                        </label>

                        <label class="relative flex items-center p-4 border-2 rounded-lg cursor-pointer transition
                            {{ $priority === 'normal' ? 'border-blue-500 bg-blue-50 dark:bg-blue-900/20' : 'border-gray-300 dark:border-gray-600 hover:border-gray-400' }}">
                            <input 
                                type="radio" 
                                wire:model="priority" 
                                value="normal"
                                class="sr-only"
                            />
                            <div class="text-center w-full">
                                <div class="text-2xl mb-1">🔵</div>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">Normal</p>
                            </div>
                        </label>

                        <label class="relative flex items-center p-4 border-2 rounded-lg cursor-pointer transition
                            {{ $priority === 'high' ? 'border-orange-500 bg-orange-50 dark:bg-orange-900/20' : 'border-gray-300 dark:border-gray-600 hover:border-gray-400' }}">
                            <input 
                                type="radio" 
                                wire:model="priority" 
                                value="high"
                                class="sr-only"
                            />
                            <div class="text-center w-full">
                                <div class="text-2xl mb-1">🟠</div>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">Alta</p>
                            </div>
                        </label>

                        <label class="relative flex items-center p-4 border-2 rounded-lg cursor-pointer transition
                            {{ $priority === 'urgent' ? 'border-red-500 bg-red-50 dark:bg-red-900/20' : 'border-gray-300 dark:border-gray-600 hover:border-gray-400' }}">
                            <input 
                                type="radio" 
                                wire:model="priority" 
                                value="urgent"
                                class="sr-only"
                            />
                            <div class="text-center w-full">
                                <div class="text-2xl mb-1">🔴</div>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">Urgente</p>
                            </div>
                        </label>
                    </div>
                    @error('priority')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Subscrição (opcional) --}}
                @if($activeSubscriptions->count() > 0)
                    <div>
                        <label for="subscription_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Subscrição Relacionada
                            <span class="text-gray-500 text-xs">(opcional)</span>
                        </label>
                        <select 
                            id="subscription_id"
                            wire:model="subscription_id"
                            class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg 
                                   focus:ring-2 focus:ring-blue-500 focus:border-transparent
                                   dark:bg-gray-700 dark:text-white">
                            <option value="">Nenhuma (Geral)</option>
                            @foreach($activeSubscriptions as $subscription)
                                <option value="{{ $subscription->id }}">
                                    {{ $subscription->plan->name }} - {{ $subscription->installationAddress->city ?? 'N/A' }}
                                </option>
                            @endforeach
                        </select>
                        @error('subscription_id')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                @endif

                {{-- Descrição --}}
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Descrição Detalhada <span class="text-red-500">*</span>
                    </label>
                    <textarea 
                        id="description"
                        wire:model="description"
                        rows="8"
                        class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg 
                               focus:ring-2 focus:ring-blue-500 focus:border-transparent
                               dark:bg-gray-700 dark:text-white
                               @error('description') border-red-500 @enderror"
                        placeholder="Descreva seu problema ou solicitação em detalhes. Quanto mais informações, melhor poderemos ajudar."></textarea>
                    @error('description')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @else
                        <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                            Mínimo 20 caracteres • {{ strlen($description) }} digitados
                        </p>
                    @enderror
                </div>

                {{-- Buttons --}}
                <div class="flex gap-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <button 
                        type="button"
                        wire:click="cancel"
                        class="flex-1 px-6 py-3 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 
                               text-gray-700 dark:text-gray-300 font-medium rounded-lg transition">
                        Cancelar
                    </button>
                    <button 
                        type="submit"
                        wire:loading.attr="disabled"
                        class="flex-1 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition 
                               disabled:opacity-50 disabled:cursor-not-allowed">
                        <span wire:loading.remove>Criar Ticket</span>
                        <span wire:loading>Criando...</span>
                    </button>
                </div>
            </form>
        </div>

        {{-- Sidebar - Tips --}}
        <div class="space-y-6">
            
            {{-- Dicas --}}
            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-6">
                <div class="flex items-start gap-3 mb-4">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                    </svg>
                    <div>
                        <h3 class="font-semibold text-blue-900 dark:text-blue-200 mb-2">
                            Dicas para um bom ticket
                        </h3>
                        <ul class="space-y-2 text-sm text-blue-800 dark:text-blue-300">
                            <li class="flex items-start gap-2">
                                <span class="text-blue-600 dark:text-blue-400">•</span>
                                <span>Seja claro e objetivo no assunto</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-blue-600 dark:text-blue-400">•</span>
                                <span>Descreva o problema em detalhes</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-blue-600 dark:text-blue-400">•</span>
                                <span>Informe quando o problema começou</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-blue-600 dark:text-blue-400">•</span>
                                <span>Mencione mensagens de erro (se houver)</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Prioridades --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Entenda as Prioridades</h3>
                <div class="space-y-3 text-sm">
                    <div class="flex items-start gap-2">
                        <span class="text-lg">🟢</span>
                        <div>
                            <p class="font-medium text-gray-900 dark:text-white">Baixa</p>
                            <p class="text-gray-600 dark:text-gray-400">Dúvidas gerais, sugestões</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-2">
                        <span class="text-lg">🔵</span>
                        <div>
                            <p class="font-medium text-gray-900 dark:text-white">Normal</p>
                            <p class="text-gray-600 dark:text-gray-400">Problemas que não impedem o uso</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-2">
                        <span class="text-lg">🟠</span>
                        <div>
                            <p class="font-medium text-gray-900 dark:text-white">Alta</p>
                            <p class="text-gray-600 dark:text-gray-400">Problemas que dificultam o uso</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-2">
                        <span class="text-lg">🔴</span>
                        <div>
                            <p class="font-medium text-gray-900 dark:text-white">Urgente</p>
                            <p class="text-gray-600 dark:text-gray-400">Serviço completamente fora do ar</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Contato Direto --}}
            <div class="bg-gradient-to-br from-orange-500 to-red-600 rounded-xl shadow-sm p-6 text-white">
                <h3 class="font-semibold mb-2">Emergência?</h3>
                <p class="text-sm opacity-90 mb-4">
                    Para problemas urgentes, ligue diretamente:
                </p>
                <a href="tel:+258840000000" 
                   class="block w-full px-4 py-3 bg-white/20 hover:bg-white/30 text-center font-semibold rounded-lg transition">
                    📞 +258 84 000 0000
                </a>
            </div>
        </div>
    </div>
</div>