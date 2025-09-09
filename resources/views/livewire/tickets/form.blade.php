{{-- Formulário de Criação/Edição --}}
<form wire:submit="saveTicket" class="space-y-6">
    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 border border-gray-200 dark:border-gray-700">
        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-6">
            {{ $selectedTicket ? 'Editar Ticket' : 'Novo Ticket' }}
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Cliente --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Cliente *
                </label>
                <select wire:model.live="customer_id" 
                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                    <option value="">Selecionar cliente...</option>
                    @foreach($customers as $customer)
                        <option value="{{ $customer->id }}">
                            {{ $customer->name }} ({{ $customer->document }})
                        </option>
                    @endforeach
                </select>
                @error('customer_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            {{-- Subscrição --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Subscrição (Opcional)
                </label>
                <select wire:model="subscription_id" 
                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                    {{ empty($subscriptions) ? 'disabled' : '' }}>
                    <option value="">Nenhuma subscrição</option>
                    @foreach($subscriptions as $subscription)
                        <option value="{{ $subscription->id }}">
                            {{ $subscription->plan->name }} - MT {{ number_format($subscription->monthly_price, 2) }}
                        </option>
                    @endforeach
                </select>
                @error('subscription_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            {{-- Atribuir para --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Atribuir para
                </label>
                <select wire:model="assigned_to" 
                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                    <option value="">Não atribuído</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
                @error('assigned_to') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            {{-- Prioridade --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Prioridade *
                </label>
                <select wire:model="priority" 
                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                    <option value="low">Baixa</option>
                    <option value="medium">Média</option>
                    <option value="high">Alta</option>
                    <option value="urgent">Urgente</option>
                </select>
                @error('priority') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            {{-- Categoria --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Categoria *
                </label>
                <select wire:model="category" 
                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                    <option value="technical">Técnico</option>
                    <option value="billing">Faturamento</option>
                    <option value="installation">Instalação</option>
                    <option value="complaint">Reclamação</option>
                    <option value="request">Solicitação</option>
                </select>
                @error('category') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            {{-- Status --}}
            @if($selectedTicket)
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Status *
                </label>
                <select wire:model="status" 
                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                    <option value="open">Aberto</option>
                    <option value="in_progress">Em Progresso</option>
                    <option value="waiting_customer">Aguardando Cliente</option>
                    <option value="resolved">Resolvido</option>
                    <option value="closed">Fechado</option>
                </select>
                @error('status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            @endif
        </div>

        {{-- Assunto --}}
        <div class="mt-6">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                Assunto *
            </label>
            <input wire:model="subject" type="text" 
                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                placeholder="Descrição breve do problema">
            @error('subject') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        {{-- Descrição --}}
        <div class="mt-6">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                Descrição *
            </label>
            <textarea wire:model="description" rows="5" 
                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                placeholder="Descreva detalhadamente o problema ou solicitação..."></textarea>
            @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        {{-- Botões --}}
        <div class="flex justify-end space-x-3 mt-6">
            <button type="button" wire:click="goToList" 
                class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700">
                Cancelar
            </button>
            <button type="submit" 
                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                {{ $selectedTicket ? 'Atualizar Ticket' : 'Criar Ticket' }}
            </button>
        </div>
    </div>
</form>