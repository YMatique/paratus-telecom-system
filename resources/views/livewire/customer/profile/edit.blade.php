<div class=" mx-auto p-4 md:p-6 space-y-8">
    {{-- Header com Avatar --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
        <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6">
            <div class="w-24 h-24 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white text-3xl font-bold shadow-lg">
                {{ substr($customer->name, 0, 1) }}
            </div>
            <div class="flex-1 text-center sm:text-left">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $customer->name }}</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    {{ $customer->type === 'company' ? 'Empresa' : 'Cliente Individual' }}
                    • Último acesso: {{ $customer->last_login_at?->diffForHumans() ?? 'Nunca' }}
                </p>
                <div class="flex flex-wrap gap-2 mt-3 justify-center sm:justify-start">
                    <span class="inline-flex items-center gap-1 px-3 py-1 bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300 text-xs font-medium rounded-full">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        Conta Ativa
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- Informações Pessoais --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                Informações Pessoais
            </h2>
            <button wire:click="$set('showPasswordForm', !{{ $showPasswordForm ? 'true' : 'false' }})"
                    class="text-sm text-blue-600 hover:text-blue-700 font-medium">
                Alterar Senha
            </button>
        </div>

        <form wire:submit="updateProfile" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nome Completo</label>
                    <input type="text" wire:model="name"
                           class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                    @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label>
                    <input type="email" wire:model="email"
                           class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                    @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Telefone</label>
                    <input type="text" wire:model="phone"
                           class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">WhatsApp</label>
                    <input type="text" wire:model="whatsapp"
                           class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Documento</label>
                    <input type="text" value="{{ $customer->formatted_document }}" disabled
                           class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl text-gray-500 dark:text-gray-400">
                </div>

                @if($customer->company_name)
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Empresa</label>
                    <input type="text" value="{{ $customer->company_name }}" disabled
                           class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl text-gray-500 dark:text-gray-400">
                </div>
                @endif
            </div>

            <div class="flex justify-end pt-2">
                <button type="submit"
                        class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-xl transition shadow-sm hover:shadow">
                    Salvar Alterações
                </button>
            </div>
        </form>

        @if($showPasswordForm)
        <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
            <h3 class="text-md font-semibold text-gray-900 dark:text-white mb-4">Alterar Senha</h3>
            <form wire:submit="updatePassword" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Senha Atual</label>
                        <input type="password" wire:model="current_password"
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                        @error('current_password') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nova Senha</label>
                        <input type="password" wire:model="password"
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                        @error('password') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Confirmar</label>
                        <input type="password" wire:model="password_confirmation"
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                    </div>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" wire:click="$set('showPasswordForm', false)"
                            class="px-4 py-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-xl">
                        Cancelar
                    </button>
                    <button type="submit"
                            class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-xl transition">
                        Atualizar Senha
                    </button>
                </div>
            </form>
        </div>
        @endif
    </div>

    {{-- Endereços --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Endereço de Instalação --}}
        <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 dark:from-emerald-900/30 dark:to-emerald-800/30 rounded-2xl p-6 border border-emerald-200 dark:border-emerald-700">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-lg font-semibold text-emerald-900 dark:text-emerald-300 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Endereço de Instalação
                </h3>
            </div>
            @if($this->installationAddress)
                <p class="text-sm text-emerald-800 dark:text-emerald-200">{{ $this->installationAddress->full_address }}</p>
                @if($this->installationAddress->reference)
                    <p class="text-xs text-emerald-700 dark:text-emerald-300 mt-1">Ref: {{ $this->installationAddress->reference }}</p>
                @endif
                <a href="{{ $this->installationAddress->google_maps_url }}" target="_blank"
                   class="inline-flex items-center gap-1 mt-3 text-xs font-medium text-emerald-600 hover:text-emerald-700">
                    Ver no Maps
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                </a>
            @else
                <p class="text-sm text-emerald-600 dark:text-emerald-400">Não informado</p>
            @endif
        </div>

        {{-- Endereço de Faturamento --}}
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/30 dark:to-blue-800/30 rounded-2xl p-6 border border-blue-200 dark:border-blue-700">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-lg font-semibold text-blue-900 dark:text-blue-300 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    Endereço de Faturamento
                </h3>
            </div>
            @if($this->billingAddress)
                <p class="text-sm text-blue-800 dark:text-blue-200">{{ $this->billingAddress->full_address }}</p>
            @else
                <p class="text-sm text-blue-600 dark:text-blue-400">Mesmo que instalação</p>
            @endif
        </div>
    </div>

    {{-- Assinatura Ativa --}}
    @if($this->activeSubscription)
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
                Assinatura Ativa
            </h2>
            <span class="px-3 py-1 bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300 text-xs font-semibold rounded-full">
                {{ ucfirst($this->activeSubscription->status) }}
            </span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <p class="text-sm text-gray-600 dark:text-gray-400">Plano</p>
                <p class="font-semibold text-gray-900 dark:text-white">{{ $this->activeSubscription->plan->name }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600 dark:text-gray-400">Valor Mensal</p>
                <p class="font-semibold text-gray-900 dark:text-white">R$ {{ number_format($this->activeSubscription->monthly_price, 2, ',', '.') }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600 dark:text-gray-400">Início</p>
                <p class="font-semibold text-gray-900 dark:text-white">{{ $this->activeSubscription->start_date->format('d/m/Y') }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600 dark:text-gray-400">Próxima Fatura</p>
                <p class="font-semibold text-gray-900 dark:text-white">{{ $this->activeSubscription->next_invoice_date?->format('d/m/Y') ?? '—' }}</p>
            </div>
        </div>

        @if($this->activeSubscription->subscriptionProducts->count() > 0)
        <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
            <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Equipamentos / Produtos</p>
            <div class="space-y-2">
                @foreach($this->activeSubscription->subscriptionProducts as $item)
                    <div class="flex items-center justify-between text-sm">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 bg-purple-100 dark:bg-purple-900 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h-4m-4 0H7m0-4h10m-6 0H7"/>
                                </svg>
                            </div>
                            <span class="font-medium text-gray-900 dark:text-white">{{ $item->product->name }}</span>
                            @if($item->equipment)
                                <span class="text-xs text-gray-500">(S/N: {{ $item->equipment->serial_number }})</span>
                            @endif
                        </div>
                        <span class="text-xs text-gray-500">{{ $item->isRental() ? 'Aluguel' : 'Venda' }}</span>
                    </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
    @else
    <div class="bg-yellow-50 dark:bg-yellow-900/30 border border-yellow-200 dark:border-yellow-700 rounded-2xl p-6 text-center">
        <svg class="w-12 h-12 mx-auto mb-3 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
        </svg>
        <p class="text-yellow-800 dark:text-yellow-300">Nenhuma assinatura ativa no momento.</p>
    </div>
    @endif
</div>

{{-- Notificações --}}
@push('scripts')
<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('profile-updated', () => {
            new Notyf().success('Perfil atualizado com sucesso!');
        });
        Livewire.on('password-updated', () => {
            new Notyf().success('Senha alterada com sucesso!');
        });
    });
</script>
@endpush