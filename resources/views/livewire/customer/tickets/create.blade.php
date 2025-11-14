<div class=" mx-auto ">
    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400 mb-6">
        <a href="{{ route('customer.tickets.index') }}" wire:navigate
            class="hover:text-blue-600 dark:hover:text-blue-400 transition">
            Tickets
        </a>
        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                clip-rule="evenodd" />
        </svg>
        <span class="font-medium text-gray-900 dark:text-white">Novo Ticket</span>
    </nav>

    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Abrir Novo Ticket</h1>
        <p class="mt-2 text-gray-600 dark:text-gray-400">
            Descreva seu problema e nossa equipe responderá em breve
        </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Formulário --}}
        <div class="lg:col-span-2">
            <form wire:submit="createTicket"
                class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 md:p-8 space-y-6">

                {{-- Assunto --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Assunto <span class="text-red-500">*</span>
                    </label>
                    <input type="text" wire:model.live="subject" maxlength="200"
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition"
                        placeholder="Ex: Internet lenta após as 18h" />
                    <div class="mt-1 text-xs text-gray-500 dark:text-gray-400 text-right">
                        {{ strlen($subject) }} / 200
                    </div>
                    @error('subject')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Categoria --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Categoria <span class="text-red-500">*</span>
                    </label>
                    <select wire:model="category"
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white">
                        <option value="general">Geral</option>
                        <option value="technical">Problema Técnico</option>
                        <option value="billing">Faturamento</option>
                        <option value="upgrade">Upgrade de Plano</option>
                        <option value="complaint">Reclamação</option>
                    </select>
                    @error('category')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Prioridade --}}
                {{-- Prioridade --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                        Prioridade <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                        @foreach ([
        'low' => ['Baixa', 'bg-green-50', 'dark:bg-green-900/20', 'border-green-500', 'text-green-900', 'dark:text-green-100'],
        'normal' => ['Normal', 'bg-blue-50', 'dark:bg-blue-900/20', 'border-blue-500', 'text-blue-900', 'dark:text-blue-100'],
        'high' => ['Alta', 'bg-orange-50', 'dark:bg-orange-900/20', 'border-orange-500', 'text-orange-900', 'dark:text-orange-100'],
        'urgent' => ['Urgente', 'bg-red-50', 'dark:bg-red-900/20', 'border-red-500', 'text-red-900', 'dark:text-red-100'],
    ] as $value => [$label, $bgLight, $bgDark, $border, $textLight, $textDark])
                            <label class="cursor-pointer">
                                <input type="radio" wire:model.live="priority" value="{{ $value }}"
                                    class="sr-only">
                                <div @class([
                                    'p-4 text-center rounded-xl border-2 transition-all duration-200',
                                    'border-gray-300 dark:border-gray-600',
                                    'hover:border-gray-400 dark:hover:border-gray-500',
                                    // Classes aplicadas apenas se $priority === $value
                                    $bgLight => $priority === $value,
                                    $bgDark => $priority === $value,
                                    $border => $priority === $value,
                                    $textLight => $priority === $value,
                                    $textDark => $priority === $value,
                                ])>
                                    <p class="text-sm font-medium">{{ $label }}</p>
                                </div>
                            </label>
                        @endforeach
                    </div>
                    @error('priority')
                        <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Subscrição --}}
                @if ($activeSubscriptions->count() > 0)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Subscrição Relacionada <span class="text-xs text-gray-500">(opcional)</span>
                        </label>
                        <select wire:model="subscription_id"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white">
                            <option value="">Nenhuma (geral)</option>
                            @foreach ($activeSubscriptions as $sub)
                                <option value="{{ $sub->id }}">
                                    {{ $sub->plan->name }}
                                    @if ($sub->installationAddress)
                                        • {{ $sub->installationAddress->city }}
                                    @endif
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endif

                {{-- Descrição --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Descrição Detalhada <span class="text-red-500">*</span>
                    </label>
                    <textarea wire:model.live="description" rows="8"
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white resize-none transition"
                        placeholder="Descreva o problema com detalhes..."></textarea>
                    <div class="mt-1 text-xs text-gray-500 dark:text-gray-400 text-right">
                        {{ strlen($description) }} caracteres
                    </div>
                    @error('description')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Botões --}}
                <div class="flex gap-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <button type="button" wire:click="cancel"
                        class="flex-1 px-6 py-3 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 font-medium rounded-xl transition">
                        Cancelar
                    </button>
                    <button type="submit" wire:loading.attr="disabled"
                        class="flex-1 flex items-center justify-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-xl transition disabled:opacity-50">
                        <span wire:loading.remove>Criar Ticket</span>
                        <span wire:loading>Enviando...</span>
                    </button>
                </div>
            </form>
        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">
            {{-- Dicas --}}
            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-2xl p-6">
                <div class="flex items-center gap-2 mb-3">
                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="font-semibold text-blue-900 dark:text-blue-200">Dicas para um bom ticket</h3>
                </div>
                <ul class="space-y-1.5 text-sm text-blue-800 dark:text-blue-300">
                    <li>• Seja específico no título</li>
                    <li>• Informe o horário do problema</li>
                    <li>• Anexe prints se possível</li>
                    <li• Mencione tentativas de solução</li>
                </ul>
            </div>

            {{-- SLA --}}
            <div
                class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Tempo de Resposta (SLA)</h3>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between items-center">
                        <span class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-green-500"></span>
                            Baixa
                        </span>
                        <span class="font-medium text-gray-600 dark:text-gray-400">até 72h</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-blue-500"></span>
                            Normal
                        </span>
                        <span class="font-medium text-gray-600 dark:text-gray-400">até 24h</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-orange-500"></span>
                            Alta
                        </span>
                        <span class="font-medium text-gray-600 dark:text-gray-400">até 8h</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-red-500"></span>
                            Urgente
                        </span>
                        <span class="font-medium text-red-600 dark:text-red-400">até 2h</span>
                    </div>
                </div>
            </div>

            {{-- Emergência --}}
            <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-2xl p-6">
                <div class="flex items-center gap-2 mb-3">
                    <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <h3 class="font-semibold text-red-900 dark:text-red-200">Emergência?</h3>
                </div>
                <p class="text-xs text-red-800 dark:text-red-300 mb-3">
                    Para falhas totais, ligue agora:
                </p>
                <a href="tel:+258840000000"
                    class="block text-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-xl transition">
                    +258 84 000 0000
                </a>
            </div>
        </div>
    </div>
</div>
