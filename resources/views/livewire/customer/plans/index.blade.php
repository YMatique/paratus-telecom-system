<div>
    {{-- Page Header --}}
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Planos Disponíveis</h1>
        <p class="mt-2 text-gray-600 dark:text-gray-400">
            Escolha o plano ideal para suas necessidades
        </p>
    </div>

    {{-- Seletor de Subscrição (se tiver múltiplas) --}}
    @if($activeSubscriptions->count() > 1)
        <div class="mb-6 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-6">
            <div class="flex items-start gap-3 mb-4">
                <svg class="w-6 h-6 text-blue-600 dark:text-blue-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div class="flex-1">
                    <h3 class="font-semibold text-blue-900 dark:text-blue-200 mb-2">
                        Você tem múltiplas subscrições
                    </h3>
                    <p class="text-sm text-blue-800 dark:text-blue-300 mb-4">
                        Selecione qual subscrição deseja fazer upgrade:
                    </p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        @foreach($activeSubscriptions as $subscription)
                            <button 
                                wire:click="selectSubscription({{ $subscription->id }})"
                                class="p-4 rounded-lg border-2 transition text-left
                                    {{ $selectedSubscriptionId === $subscription->id 
                                        ? 'border-blue-600 bg-blue-50 dark:bg-blue-900/30' 
                                        : 'border-blue-200 dark:border-blue-800 hover:border-blue-400 dark:hover:border-blue-600 bg-white dark:bg-gray-800' }}">
                                <p class="font-semibold text-gray-900 dark:text-white">
                                    {{ $subscription->plan->name }}
                                </p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ $subscription->installationAddress->city ?? 'N/A' }}
                                </p>
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Current Plan Info --}}
    @if($selectedSubscription)
        <div class="mb-6 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Seu Plano Atual</p>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
                        {{ $selectedSubscription->plan->name }}
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">
                        {{ $selectedSubscription->plan->download_speed }} MB/s • 
                        {{ number_format($selectedSubscription->price, 2, ',', '.') }} MT/mês
                    </p>
                </div>
                <div class="w-16 h-16 bg-blue-100 dark:bg-blue-900 rounded-xl flex items-center justify-center">
                    <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
            </div>
        </div>
    @endif

    {{-- Filters --}}
    <div class="mb-6 flex flex-wrap gap-2">
        <button 
            wire:click="filterByType('all')"
            class="px-4 py-2 rounded-lg text-sm font-medium transition
                {{ $filterType === 'all' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
            Todos os Planos
        </button>
        <button 
            wire:click="filterByType('residential')"
            class="px-4 py-2 rounded-lg text-sm font-medium transition
                {{ $filterType === 'residential' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
            Residencial
        </button>
        <button 
            wire:click="filterByType('business')"
            class="px-4 py-2 rounded-lg text-sm font-medium transition
                {{ $filterType === 'business' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
            Empresarial
        </button>
    </div>

    {{-- Plans Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        @foreach($plans as $plan)
            @php
                $isCurrentPlan = $this->isCurrentPlan($plan);
                $isUpgrade = $this->isUpgrade($plan);
            @endphp

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border-2 transition
                {{ $isCurrentPlan ? 'border-blue-500' : 'border-gray-200 dark:border-gray-700 hover:border-blue-300 dark:hover:border-blue-700' }}
                {{ $plan->is_featured ? 'lg:-mt-4 lg:mb-4' : '' }}">
                
                {{-- Featured Badge --}}
                @if($plan->is_featured)
                    <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white text-center py-2 text-sm font-semibold">
                        ⭐ MAIS POPULAR
                    </div>
                @endif

                {{-- Current Plan Badge --}}
                @if($isCurrentPlan)
                    <div class="bg-blue-600 text-white text-center py-2 text-sm font-semibold">
                        ✓ SEU PLANO ATUAL
                    </div>
                @endif

                <div class="p-6">
                    {{-- Plan Type --}}
                    <div class="inline-flex items-center gap-1 px-3 py-1 bg-gray-100 dark:bg-gray-700 rounded-full text-xs font-medium text-gray-700 dark:text-gray-300 mb-4">
                        {{ $plan->type === 'residential' ? '🏠 Residencial' : '🏢 Empresarial' }}
                    </div>

                    {{-- Plan Name --}}
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                        {{ $plan->name }}
                    </h3>

                    {{-- Price --}}
                    <div class="mb-6">
                        <div class="flex items-baseline gap-2">
                            <span class="text-4xl font-bold text-gray-900 dark:text-white">
                                {{ number_format($plan->price, 0) }}
                            </span>
                            <span class="text-gray-600 dark:text-gray-400">MT/mês</span>
                        </div>
                        @if($plan->setup_fee > 0)
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                + {{ number_format($plan->setup_fee, 0) }} MT taxa de instalação
                            </p>
                        @endif
                    </div>

                    {{-- Speed --}}
                    <div class="mb-6 p-4 bg-gradient-to-br from-blue-50 to-purple-50 dark:from-blue-900/20 dark:to-purple-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Download</span>
                            <span class="text-2xl font-bold text-blue-600 dark:text-blue-400">
                                {{ $plan->download_speed }} MB/s
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Upload</span>
                            <span class="text-lg font-semibold text-purple-600 dark:text-purple-400">
                                {{ $plan->upload_speed }} MB/s
                            </span>
                        </div>
                    </div>

                    {{-- Features --}}
                    @if($plan->features)
                        <ul class="space-y-3 mb-6">
                            @foreach(json_decode($plan->features, true) ?? [] as $feature)
                                <li class="flex items-start gap-2">
                                    <svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    <span class="text-sm text-gray-700 dark:text-gray-300">{{ $feature }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif

                    {{-- Description --}}
                    @if($plan->description)
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">
                            {{ $plan->description }}
                        </p>
                    @endif

                    {{-- CTA Button --}}
                    @if($isCurrentPlan)
                        <button 
                            disabled
                            class="w-full px-6 py-3 bg-gray-300 dark:bg-gray-600 text-gray-600 dark:text-gray-400 font-semibold rounded-lg cursor-not-allowed">
                            Plano Atual
                        </button>
                    @elseif($selectedSubscription && !$isUpgrade)
                        <button 
                            disabled
                            class="w-full px-6 py-3 bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-400 font-semibold rounded-lg cursor-not-allowed">
                            Downgrade não disponível
                        </button>
                    @elseif(!$selectedSubscriptionId && $activeSubscriptions->count() > 0)
                        <button 
                            disabled
                            class="w-full px-6 py-3 bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-400 font-semibold rounded-lg cursor-not-allowed">
                            Selecione uma subscrição
                        </button>
                    @else
                        <button 
                            wire:click="openUpgradeModal({{ $plan->id }})"
                            class="w-full px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold rounded-lg transition shadow-lg shadow-blue-500/50">
                            {{ $selectedSubscription ? 'Fazer Upgrade' : 'Solicitar Plano' }}
                        </button>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    {{-- Info Box --}}
    <div class="bg-gradient-to-br from-orange-50 to-red-50 dark:from-orange-900/20 dark:to-red-900/20 border border-orange-200 dark:border-orange-800 rounded-xl p-6">
        <div class="flex items-start gap-4">
            <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900/30 rounded-lg flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <h3 class="font-semibold text-orange-900 dark:text-orange-200 mb-2">
                    Como funciona o upgrade?
                </h3>
                <ul class="space-y-2 text-sm text-orange-800 dark:text-orange-300">
                    <li class="flex items-start gap-2">
                        <span>1.</span>
                        <span>Você solicita o upgrade escolhendo o plano desejado</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span>2.</span>
                        <span>Nossa equipe técnica analisa a viabilidade</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span>3.</span>
                        <span>Entramos em contato para agendar a mudança</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span>4.</span>
                        <span>O novo plano é ativado sem interrupção do serviço</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    {{-- Modal de Upgrade --}}
    @if($showUpgradeModal && $selectedPlan)
        <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4" 
             wire:click="closeUpgradeModal">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl max-w-lg w-full max-h-[90vh] overflow-y-auto"
                 wire:click.stop>
                
                {{-- Header --}}
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-start justify-between">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                                Solicitar Upgrade
                            </h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                Plano: {{ $selectedPlan->name }}
                            </p>
                        </div>
                        <button 
                            wire:click="closeUpgradeModal"
                            class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Body --}}
                <div class="p-6 space-y-6">
                    {{-- Plan Comparison --}}
                    @if($selectedSubscription)
                        <div class="grid grid-cols-2 gap-4 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                            <div>
                                <p class="text-xs text-gray-600 dark:text-gray-400 mb-1">Plano Atual</p>
                                <p class="font-semibold text-gray-900 dark:text-white">
                                    {{ $selectedSubscription->plan->name }}
                                </p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ $selectedSubscription->plan->download_speed }} MB/s
                                </p>
                                <p class="text-sm font-medium text-gray-900 dark:text-white mt-1">
                                    {{ number_format($selectedSubscription->price, 2, ',', '.') }} MT/mês
                                </p>
                            </div>
                            <div class="border-l-2 border-green-500 pl-4">
                                <p class="text-xs text-green-600 dark:text-green-400 mb-1">Novo Plano</p>
                                <p class="font-semibold text-gray-900 dark:text-white">
                                    {{ $selectedPlan->name }}
                                </p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ $selectedPlan->download_speed }} MB/s
                                </p>
                                <p class="text-sm font-medium text-green-600 dark:text-green-400 mt-1">
                                    {{ number_format($selectedPlan->price, 2, ',', '.') }} MT/mês
                                </p>
                            </div>
                        </div>
                    @endif

                    {{-- Reason --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Por que deseja fazer upgrade?
                        </label>
                        <textarea 
                            wire:model="upgradeReason"
                            rows="4"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg 
                                   focus:ring-2 focus:ring-blue-500 focus:border-transparent
                                   dark:bg-gray-700 dark:text-white
                                   @error('upgradeReason') border-red-500 @enderror"
                            placeholder="Ex: Preciso de mais velocidade para trabalhar de casa, fazer videoconferências, etc."></textarea>
                        @error('upgradeReason')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @else
                            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                Mínimo 10 caracteres
                            </p>
                        @enderror
                    </div>

                    {{-- Info --}}
                    <div class="p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                        <p class="text-sm text-blue-800 dark:text-blue-300">
                            ℹ️ Após a solicitação, nossa equipe entrará em contato para confirmar a viabilidade técnica e agendar a mudança.
                        </p>
                    </div>
                </div>

                {{-- Footer --}}
                <div class="p-6 border-t border-gray-200 dark:border-gray-700 flex gap-3">
                    <button 
                        wire:click="closeUpgradeModal"
                        class="flex-1 px-6 py-3 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 font-medium rounded-lg transition">
                        Cancelar
                    </button>
                    <button 
                        wire:click="requestUpgrade"
                        wire:loading.attr="disabled"
                        class="flex-1 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition disabled:opacity-50">
                        <span wire:loading.remove>Enviar Solicitação</span>
                        <span wire:loading>Enviando...</span>
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>