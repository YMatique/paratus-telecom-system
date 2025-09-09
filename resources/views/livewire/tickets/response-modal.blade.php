{{-- Modal de Resposta --}}
<div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" 
     x-data x-init="$el.focus()" tabindex="-1">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-2/3 lg:w-1/2 shadow-lg rounded-md bg-white dark:bg-gray-800 dark:border-gray-700">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">
                Adicionar Resposta ao Ticket #{{ $selectedTicket->ticket_number }}
            </h3>
            
            <form wire:submit="addResponse">
                {{-- Campo de resposta --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Resposta *
                    </label>
                    <textarea wire:model="response_text" rows="6" 
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Digite sua resposta..."></textarea>
                    @error('response_text') 
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span> 
                    @enderror
                </div>

                {{-- Opções da resposta --}}
                <div class="flex items-center space-x-6 mb-6">
                    <label class="flex items-center">
                        <input type="checkbox" wire:model="is_internal" 
                            class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 dark:border-gray-600">
                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                            <span class="font-medium">Nota interna</span>
                            <span class="text-gray-500 block text-xs">Visível apenas para a equipe</span>
                        </span>
                    </label>
                    
                    <label class="flex items-center">
                        <input type="checkbox" wire:model="is_solution" 
                            class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 dark:border-gray-600">
                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                            <span class="font-medium">Esta é a solução</span>
                            <span class="text-gray-500 block text-xs">Marcará o ticket como resolvido</span>
                        </span>
                    </label>
                </div>

                {{-- Botões de ação --}}
                <div class="flex justify-end space-x-3">
                    <button type="button" wire:click="$set('showResponseModal', false)" 
                        class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700 transition-colors">
                        Cancelar
                    </button>
                    <button type="submit" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 disabled:opacity-50 transition-colors"
                        wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="addResponse">
                            Adicionar Resposta
                        </span>
                        <span wire:loading wire:target="addResponse" class="flex items-center">
                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Adicionando...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>