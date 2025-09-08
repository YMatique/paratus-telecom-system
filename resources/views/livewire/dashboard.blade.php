{{-- resources/views/livewire/dashboard.blade.php --}}
<div class="space-y-6">
    {{-- Header com Resumo Executivo --}}
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-lg shadow-lg text-white p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold">Dashboard Executivo</h1>
                <p class="text-blue-100 mt-1">Visão geral do provedor de internet - {{ now()->format('d/m/Y H:i') }}</p>
            </div>
            <div class="text-right">
                <div class="text-sm text-blue-100">Receita Total (Mês)</div>
                <div class="text-3xl font-bold">{{ $stats['revenue']['formatted'] }}</div>
                @if($stats['revenue']['growth'] != 0)
                    <div class="text-sm {{ $stats['revenue']['growth_positive'] ? 'text-green-300' : 'text-red-300' }}">
                        {{ $stats['revenue']['growth_positive'] ? '+' : '' }}{{ $stats['revenue']['growth'] }}% vs mês anterior
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- KPIs Principais --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        {{-- Total de Clientes --}}
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="ml-4 flex-1">
                    <h3 class="text-sm font-medium text-gray-500">Total de Clientes</h3>
                    <div class="flex items-baseline">
                        <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['customers']['total']) }}</p>
                        @if($stats['customers']['growth'] != 0)
                            <span class="ml-2 text-sm font-medium {{ $stats['customers']['growth_positive'] ? 'text-green-600' : 'text-red-600' }}">
                                {{ $stats['customers']['growth_positive'] ? '+' : '' }}{{ $stats['customers']['growth'] }}%
                            </span>
                        @endif
                    </div>
                    <p class="text-xs text-gray-500 mt-1">{{ $stats['customers']['active'] ?? 0 }} ativos</p>
                </div>
            </div>
        </div>

        {{-- Conexões Ativas --}}
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"/>
                        </svg>
                    </div>
                </div>
                <div class="ml-4 flex-1">
                    <h3 class="text-sm font-medium text-gray-500">Conexões Ativas</h3>
                    <div class="flex items-baseline">
                        <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['subscriptions']['active']) }}</p>
                        @if($stats['subscriptions']['growth'] != 0)
                            <span class="ml-2 text-sm font-medium {{ $stats['subscriptions']['growth_positive'] ? 'text-green-600' : 'text-red-600' }}">
                                {{ $stats['subscriptions']['growth_positive'] ? '+' : '' }}{{ $stats['subscriptions']['growth'] }}%
                            </span>
                        @endif
                    </div>
                    <p class="text-xs text-gray-500 mt-1">{{ $stats['subscriptions']['suspended'] ?? 0 }} suspensas</p>
                </div>
            </div>
        </div>

        {{-- Faturamento Pendente --}}
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-yellow-500">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                        </svg>
                    </div>
                </div>
                <div class="ml-4 flex-1">
                    <h3 class="text-sm font-medium text-gray-500">A Receber</h3>
                    <div class="flex items-baseline">
                        <p class="text-2xl font-semibold text-gray-900">{{ $stats['financial']['pending_formatted'] ?? '0 MT' }}</p>
                    </div>
                    <p class="text-xs text-red-600 mt-1">{{ $stats['financial']['overdue_count'] ?? 0 }} vencidas</p>
                </div>
            </div>
        </div>

        {{-- Suporte Técnico --}}
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-red-500">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M12 2.25a9.75 9.75 0 11-9.75 9.75A9.75 9.75 0 0112 2.25z"/>
                        </svg>
                    </div>
                </div>
                <div class="ml-4 flex-1">
                    <h3 class="text-sm font-medium text-gray-500">Tickets Abertos</h3>
                    <div class="flex items-baseline">
                        <p class="text-2xl font-semibold text-gray-400">Em breve</p>
                    </div>
                    <p class="text-xs text-gray-400 mt-1">Sistema em desenvolvimento</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Métricas Operacionais --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Resumo Financeiro --}}
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Resumo Financeiro</h3>
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
            </div>
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Receita Realizada</span>
                    <span class="font-semibold text-green-600">{{ $stats['financial']['paid_formatted'] ?? '0 MT' }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Faturas Pendentes</span>
                    <span class="font-semibold text-yellow-600">{{ $stats['financial']['pending_formatted'] ?? '0 MT' }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Em Atraso</span>
                    <span class="font-semibold text-red-600">{{ $stats['financial']['overdue_formatted'] ?? '0 MT' }}</span>
                </div>
                <div class="pt-3 border-t border-gray-200">
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-medium text-gray-900">Total do Mês</span>
                        <span class="font-bold text-lg text-gray-900">{{ $stats['revenue']['formatted'] }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Status das Conexões --}}
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Status das Conexões</h3>
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </div>
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Ativas</span>
                    <div class="flex items-center">
                        <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                        <span class="font-semibold">{{ $stats['subscriptions']['active'] ?? 0 }}</span>
                    </div>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Suspensas</span>
                    <div class="flex items-center">
                        <div class="w-2 h-2 bg-red-500 rounded-full mr-2"></div>
                        <span class="font-semibold">{{ $stats['subscriptions']['suspended'] ?? 0 }}</span>
                    </div>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Aguardando Instalação</span>
                    <div class="flex items-center">
                        <div class="w-2 h-2 bg-yellow-500 rounded-full mr-2"></div>
                        <span class="font-semibold">{{ $stats['subscriptions']['pending_installation'] ?? 0 }}</span>
                    </div>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Canceladas (Mês)</span>
                    <div class="flex items-center">
                        <div class="w-2 h-2 bg-gray-500 rounded-full mr-2"></div>
                        <span class="font-semibold">{{ $stats['subscriptions']['cancelled_month'] ?? 0 }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Equipamentos e Estoque --}}
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Equipamentos</h3>
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
            </div>
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Disponíveis</span>
                    <span class="font-semibold text-green-600">{{ $stats['equipment']['available'] ?? 0 }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Instalados</span>
                    <span class="font-semibold text-blue-600">{{ $stats['equipment']['installed'] ?? 0 }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Em Manutenção</span>
                    <span class="font-semibold text-yellow-600">{{ $stats['equipment']['maintenance'] ?? 0 }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Estoque Baixo</span>
                    <span class="font-semibold text-red-600">{{ $stats['equipment']['low_stock'] ?? 0 }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Gráficos e Análises --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Gráfico de Receita Mensal --}}
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Evolução da Receita</h3>
                <button class="text-sm text-blue-600 hover:text-blue-800">Ver detalhes</button>
            </div>
            <div class="h-64 bg-gradient-to-t from-blue-50 to-white rounded-lg flex items-center justify-center border border-gray-100">
                <div class="text-center">
                    <div class="text-3xl font-bold text-blue-600 mb-2">{{ $stats['revenue']['formatted'] }}</div>
                    <div class="text-sm text-gray-600 mb-4">Receita do mês atual</div>
                    <div class="text-xs text-gray-500">Gráfico interativo em desenvolvimento</div>
                </div>
            </div>
        </div>

        {{-- Distribuição por Planos --}}
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Distribuição por Planos</h3>
                <button class="text-sm text-blue-600 hover:text-blue-800">Ver relatório</button>
            </div>
            <div class="space-y-3">
                @forelse($stats['plans_distribution'] ?? [] as $plan)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-blue-500 rounded mr-3"></div>
                            <span class="text-sm text-gray-700">{{ $plan['name'] ?? 'Plano' }}</span>
                        </div>
                        <div class="text-right">
                            <span class="text-sm font-semibold text-gray-900">{{ $plan['subscribers'] ?? 0 }}</span>
                            <span class="text-xs text-gray-500 ml-1">({{ $plan['percentage'] ?? 0 }}%)</span>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <div class="text-gray-400 text-sm">Carregando distribuição de planos...</div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Tabelas de Dados Recentes --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Atividade Recente --}}
        <div class="bg-white rounded-lg shadow-md">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">Atividade Recente</h3>
                    <button wire:click="redirectToCustomers" class="text-sm text-blue-600 hover:text-blue-800">Ver todas</button>
                </div>
            </div>
            <div class="px-6 py-4">
                @if($recentCustomers->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentCustomers as $customer)
                            <div class="flex items-center space-x-4">
                                <div class="w-10 h-10 bg-{{ $customer['status_color'] }}-100 rounded-full flex items-center justify-center">
                                    <span class="text-sm font-medium text-{{ $customer['status_color'] }}-600">{{ $customer['initials'] }}</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ $customer['name'] }}</p>
                                    <p class="text-xs text-gray-500">{{ $customer['email'] }}</p>
                                </div>
                                <div>
                                    <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full bg-{{ $customer['status_color'] }}-100 text-{{ $customer['status_color'] }}-800">
                                        {{ $customer['status_label'] }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <p class="mt-2 text-sm text-gray-600">Nenhum cliente cadastrado</p>
                        <button wire:click="redirectToCustomers" class="mt-2 text-sm font-medium text-blue-600 hover:text-blue-500">
                            Cadastrar primeiro cliente
                        </button>
                    </div>
                @endif
            </div>
        </div>

        {{-- Alertas e Tarefas --}}
        <div class="bg-white rounded-lg shadow-md">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">Alertas e Pendências</h3>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                        {{ ($stats['alerts']['total'] ?? 0) }} alertas
                    </span>
                </div>
            </div>
            <div class="px-6 py-4">
                <div class="space-y-4">
                    @if(($stats['financial']['overdue_count'] ?? 0) > 0)
                        <div class="flex items-start space-x-3">
                            <div class="w-2 h-2 bg-red-500 rounded-full mt-2"></div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">Faturas Vencidas</p>
                                <p class="text-xs text-gray-600">{{ $stats['financial']['overdue_count'] }} faturas precisam de atenção</p>
                            </div>
                            <button class="text-xs text-blue-600 hover:text-blue-800">Ver</button>
                        </div>
                    @endif
                    
                    @if(($stats['equipment']['low_stock'] ?? 0) > 0)
                        <div class="flex items-start space-x-3">
                            <div class="w-2 h-2 bg-yellow-500 rounded-full mt-2"></div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">Estoque Baixo</p>
                                <p class="text-xs text-gray-600">{{ $stats['equipment']['low_stock'] }} produtos com estoque baixo</p>
                            </div>
                            <button class="text-xs text-blue-600 hover:text-blue-800">Ver</button>
                        </div>
                    @endif

                    @if(($stats['subscriptions']['pending_installation'] ?? 0) > 0)
                        <div class="flex items-start space-x-3">
                            <div class="w-2 h-2 bg-blue-500 rounded-full mt-2"></div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">Instalações Pendentes</p>
                                <p class="text-xs text-gray-600">{{ $stats['subscriptions']['pending_installation'] }} clientes aguardando instalação</p>
                            </div>
                            <button class="text-xs text-blue-600 hover:text-blue-800">Ver</button>
                        </div>
                    @endif

                    @if(($stats['financial']['overdue_count'] ?? 0) == 0 && ($stats['equipment']['low_stock'] ?? 0) == 0 && ($stats['subscriptions']['pending_installation'] ?? 0) == 0)
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="mt-2 text-sm text-green-600 font-medium">Tudo em ordem!</p>
                            <p class="text-xs text-gray-500">Nenhum alerta no momento</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Ações Rápidas Expandidas --}}
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-6">Ações Rápidas</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
            <button wire:click="redirectToCustomers" class="group flex flex-col items-center p-4 rounded-lg border-2 border-dashed border-gray-300 hover:border-blue-400 hover:bg-blue-50 transition-colors">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center group-hover:bg-blue-200 transition-colors">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.5a3.375 3.375 0 006.75 0v-3.75A3.375 3.375 0 004 12.375V19.5z"/>
                    </svg>
                </div>
                <span class="mt-2 text-sm font-medium text-gray-900">Novo Cliente</span>
            </button>

            <button wire:click="redirectToSubscriptions" class="group flex flex-col items-center p-4 rounded-lg border-2 border-dashed border-gray-300 hover:border-green-400 hover:bg-green-50 transition-colors">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center group-hover:bg-green-200 transition-colors">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"/>
                    </svg>
                </div>
                <span class="mt-2 text-sm font-medium text-gray-900">Nova Conexão</span>
            </button>

            <button wire:click="redirectToInvoices" class="group flex flex-col items-center p-4 rounded-lg border-2 border-dashed border-gray-300 hover:border-yellow-400 hover:bg-yellow-50 transition-colors">
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center group-hover:bg-yellow-200 transition-colors">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <span class="mt-2 text-sm font-medium text-gray-900">Nova Fatura</span>
            </button>

            <button class="group flex flex-col items-center p-4 rounded-lg border-2 border-dashed border-gray-300 hover:border-purple-400 hover:bg-purple-50 transition-colors">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center group-hover:bg-purple-200 transition-colors">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                </div>
                <span class="mt-2 text-sm font-medium text-gray-900">Equipamentos</span>
            </button>

            <button class="group flex flex-col items-center p-4 rounded-lg border-2 border-dashed border-gray-300 hover:border-indigo-400 hover:bg-indigo-50 transition-colors">
                <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center group-hover:bg-indigo-200 transition-colors">
                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <span class="mt-2 text-sm font-medium text-gray-900">Relatórios</span>
            </button>

            <button class="group flex flex-col items-center p-4 rounded-lg border-2 border-dashed border-gray-300 hover:border-red-400 hover:bg-red-50 transition-colors opacity-50">
                <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                    </svg>
                </div>
                <span class="mt-2 text-sm font-medium text-gray-400">Tickets</span>
                <span class="text-xs text-gray-400">Em breve</span>
            </button>
        </div>
    </div>

    {{-- Estatísticas Avançadas --}}
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        {{-- Churn Rate --}}
        <div class="bg-white rounded-lg shadow-md p-6 text-center">
            <div class="text-3xl font-bold text-red-600">{{ $stats['advanced']['churn_rate'] ?? '2.1' }}%</div>
            <div class="text-sm text-gray-600 mt-1">Taxa de Cancelamento</div>
            <div class="text-xs text-gray-500 mt-2">Últimos 3 meses</div>
        </div>

        {{-- ARPU --}}
        <div class="bg-white rounded-lg shadow-md p-6 text-center">
            <div class="text-3xl font-bold text-green-600">{{ $stats['advanced']['arpu'] ?? '1,850' }} MT</div>
            <div class="text-sm text-gray-600 mt-1">ARPU Médio</div>
            <div class="text-xs text-gray-500 mt-2">Receita por usuário</div>
        </div>

        {{-- Tempo Médio de Instalação --}}
        <div class="bg-white rounded-lg shadow-md p-6 text-center">
            <div class="text-3xl font-bold text-blue-600">{{ $stats['advanced']['avg_install_time'] ?? '3.2' }} dias</div>
            <div class="text-sm text-gray-600 mt-1">Tempo de Instalação</div>
            <div class="text-xs text-gray-500 mt-2">Média do mês</div>
        </div>

        {{-- Satisfação (quando tiver tickets) --}}
        <div class="bg-white rounded-lg shadow-md p-6 text-center">
            <div class="text-3xl font-bold text-gray-400">Em breve</div>
            <div class="text-sm text-gray-400 mt-1">Satisfação NPS</div>
            <div class="text-xs text-gray-400 mt-2">Net Promoter Score</div>
        </div>
    </div>
</div>