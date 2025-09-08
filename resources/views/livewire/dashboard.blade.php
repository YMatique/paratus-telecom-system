{{-- resources/views/livewire/dashboard.blade.php --}}
<div>
    {{-- Cards de Estatísticas --}}
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4 mb-8">
        {{-- Total de Clientes --}}
        <div class="relative overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:px-6 sm:py-6 dark:bg-gray-800">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="flex h-8 w-8 items-center justify-center rounded-md bg-blue-500">
                        <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                        </svg>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate dark:text-gray-400">Total de Clientes</dt>
                        <dd class="flex items-baseline">
                            <div class="text-2xl font-semibold text-gray-900 dark:text-white">
                                {{ number_format($stats['customers']['total']) }}
                            </div>
                            @if($stats['customers']['total'] > 0)
                                <div class="ml-2 flex items-baseline text-sm font-semibold {{ $stats['customers']['growth_positive'] ? 'text-green-600' : 'text-red-600' }}">
                                    <svg class="h-4 w-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        @if($stats['customers']['growth_positive'])
                                            <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                        @else
                                            <path fill-rule="evenodd" d="M14.707 10.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 12.586V5a1 1 0 012 0v7.586l2.293-2.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        @endif
                                    </svg>
                                    <span class="sr-only">{{ $stats['customers']['growth_positive'] ? 'Aumento' : 'Diminuição' }} de </span>
                                    {{ abs($stats['customers']['growth']) }}%
                                </div>
                            @endif
                        </dd>
                    </dl>
                </div>
            </div>
            <div class="mt-1">
                <p class="text-sm text-gray-500 dark:text-gray-400">vs mês anterior</p>
            </div>
        </div>

        {{-- Subscrições Ativas --}}
        <div class="relative overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:px-6 sm:py-6 dark:bg-gray-800">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="flex h-8 w-8 items-center justify-center rounded-md bg-green-500">
                        <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.288 15.038a5.25 5.25 0 017.424 0M5.106 11.856c3.807-3.808 9.98-3.808 13.788 0M1.924 8.674c5.565-5.565 14.587-5.565 20.152 0M12.53 18.22l-.53.53-.53-.53a.75.75 0 011.06 0z" />
                        </svg>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate dark:text-gray-400">Subscrições Ativas</dt>
                        <dd class="flex items-baseline">
                            <div class="text-2xl font-semibold text-gray-900 dark:text-white">
                                {{ number_format($stats['subscriptions']['active']) }}
                            </div>
                            @if($stats['subscriptions']['active'] > 0)
                                <div class="ml-2 flex items-baseline text-sm font-semibold {{ $stats['subscriptions']['growth_positive'] ? 'text-green-600' : 'text-red-600' }}">
                                    <svg class="h-4 w-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        @if($stats['subscriptions']['growth_positive'])
                                            <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                        @else
                                            <path fill-rule="evenodd" d="M14.707 10.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 12.586V5a1 1 0 012 0v7.586l2.293-2.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        @endif
                                    </svg>
                                    {{ abs($stats['subscriptions']['growth']) }}%
                                </div>
                            @endif
                        </dd>
                    </dl>
                </div>
            </div>
            <div class="mt-1">
                <p class="text-sm text-gray-500 dark:text-gray-400">vs mês anterior</p>
            </div>
        </div>

        {{-- Receita do Mês --}}
        <div class="relative overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:px-6 sm:py-6 dark:bg-gray-800">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="flex h-8 w-8 items-center justify-center rounded-md bg-yellow-500">
                        <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate dark:text-gray-400">Receita do Mês</dt>
                        <dd class="flex items-baseline">
                            <div class="text-2xl font-semibold text-gray-900 dark:text-white">
                                {{ $stats['revenue']['formatted'] }}
                            </div>
                            @if($stats['revenue']['monthly'] > 0)
                                <div class="ml-2 flex items-baseline text-sm font-semibold {{ $stats['revenue']['growth_positive'] ? 'text-green-600' : 'text-red-600' }}">
                                    <svg class="h-4 w-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        @if($stats['revenue']['growth_positive'])
                                            <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                        @else
                                            <path fill-rule="evenodd" d="M14.707 10.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 12.586V5a1 1 0 012 0v7.586l2.293-2.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        @endif
                                    </svg>
                                    {{ abs($stats['revenue']['growth']) }}%
                                </div>
                            @endif
                        </dd>
                    </dl>
                </div>
            </div>
            <div class="mt-1">
                <p class="text-sm text-gray-500 dark:text-gray-400">vs mês anterior</p>
            </div>
        </div>

        {{-- Tickets Abertos (Placeholder) --}}
        <div class="relative overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:px-6 sm:py-6 dark:bg-gray-800 border-2 border-dashed border-gray-300 dark:border-gray-600">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="flex h-8 w-8 items-center justify-center rounded-md bg-gray-400">
                        <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 010 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 010-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375z" />
                        </svg>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-400 truncate">Tickets Abertos</dt>
                        <dd class="flex items-baseline">
                            <div class="text-2xl font-semibold text-gray-400">Em breve</div>
                        </dd>
                    </dl>
                </div>
            </div>
            <div class="mt-1">
                <p class="text-sm text-gray-400">Sistema de suporte</p>
            </div>
        </div>
    </div>

    {{-- Gráficos --}}
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2 mb-8">
        {{-- Gráfico de Receita --}}
        <div class="bg-white overflow-hidden shadow rounded-lg dark:bg-gray-800">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">Receita Mensal</h3>
                <div class="mt-5">
                    <div class="h-64 bg-gray-50 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                        <div class="text-center">
                            <p class="text-2xl font-bold text-gray-600 dark:text-gray-300 mb-2">
                                {{ $stats['revenue']['formatted'] }}
                            </p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Receita atual do mês</p>
                            <p class="text-xs text-gray-400 mt-2">Gráfico detalhado em breve</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Gráfico de Novos Clientes --}}
        <div class="bg-white overflow-hidden shadow rounded-lg dark:bg-gray-800">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">Novos Clientes</h3>
                <div class="mt-5">
                    <div class="h-64 bg-gray-50 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                        <div class="text-center">
                            <p class="text-2xl font-bold text-gray-600 dark:text-gray-300 mb-2">
                                {{ $stats['customers']['total'] }}
                            </p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Total de clientes</p>
                            <p class="text-xs text-gray-400 mt-2">Gráfico de evolução em breve</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabelas de Dados Recentes --}}
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2 mb-8">
        {{-- Clientes Recentes --}}
        <div class="bg-white shadow overflow-hidden sm:rounded-lg dark:bg-gray-800">
            <div class="px-4 py-5 sm:px-6 flex items-center justify-between">
                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">Clientes Recentes</h3>
                <button wire:click="redirectToCustomers" class="text-sm font-medium text-blue-600 hover:text-blue-500 dark:text-blue-400">Ver todos</button>
            </div>
            <div class="border-t border-gray-200 dark:border-gray-700">
                @if($recentCustomers->count() > 0)
                    <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($recentCustomers as $customer)
                            <li class="px-4 py-4 sm:px-6">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 flex-shrink-0">
                                            <div class="h-10 w-10 rounded-full bg-{{ $customer['status_color'] }}-500 flex items-center justify-center">
                                                <span class="text-sm font-medium text-white">{{ $customer['initials'] }}</span>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $customer['name'] }}</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ $customer['email'] }}</div>
                                        </div>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $customer['status_color'] }}-100 text-{{ $customer['status_color'] }}-800 dark:bg-{{ $customer['status_color'] }}-900/20 dark:text-{{ $customer['status_color'] }}-400">
                                            {{ $customer['status_label'] }}
                                        </span>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="px-4 py-8 text-center">
                        <p class="text-sm text-gray-500 dark:text-gray-400">Nenhum cliente cadastrado ainda</p>
                        <button wire:click="redirectToCustomers" class="mt-2 text-sm font-medium text-blue-600 hover:text-blue-500">
                            Cadastrar primeiro cliente
                        </button>
                    </div>
                @endif
            </div>
        </div>

        {{-- Tickets Recentes (Placeholder) --}}
        <div class="bg-white shadow overflow-hidden sm:rounded-lg dark:bg-gray-800 border-2 border-dashed border-gray-300 dark:border-gray-600">
            <div class="px-4 py-5 sm:px-6 flex items-center justify-between">
                <h3 class="text-lg leading-6 font-medium text-gray-400">Tickets Recentes</h3>
                <span class="text-sm font-medium text-gray-400">Em breve</span>
            </div>
            <div class="border-t border-gray-300 dark:border-gray-600">
                <div class="px-4 py-8 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                    <p class="mt-2 text-sm text-gray-400">Sistema de tickets em desenvolvimento</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Ações Rápidas --}}
    <div class="bg-white overflow-hidden shadow rounded-lg dark:bg-gray-800">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4 dark:text-white">Ações Rápidas</h3>
            <div class="grid grid-cols-2 gap-4 sm:grid-cols-4">
                <button wire:click="redirectToCustomers" class="relative group bg-white p-6 focus-within:ring-2 focus-within:ring-inset focus-within:ring-blue-500 rounded-lg hover:bg-gray-50 border-2 border-dashed border-gray-300 hover:border-gray-400 dark:bg-gray-700 dark:border-gray-600 dark:hover:bg-gray-600">
                    <div>
                        <span class="rounded-lg inline-flex p-3 bg-blue-50 text-blue-700 ring-4 ring-white dark:bg-blue-900/20 dark:text-blue-400">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.5a3.375 3.375 0 006.75 0v-3.75A3.375 3.375 0 004 12.375V19.5z" />
                            </svg>
                        </span>
                    </div>
                    <div class="mt-8">
                        <h3 class="text-sm font-medium text-gray-900 dark:text-white">
                            <span class="absolute inset-0" aria-hidden="true"></span>
                            Novo Cliente
                        </h3>
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                            Cadastrar novo cliente no sistema
                        </p>
                    </div>
                </button>

                <button wire:click="redirectToSubscriptions" class="relative group bg-white p-6 focus-within:ring-2 focus-within:ring-inset focus-within:ring-blue-500 rounded-lg hover:bg-gray-50 border-2 border-dashed border-gray-300 hover:border-gray-400 dark:bg-gray-700 dark:border-gray-600 dark:hover:bg-gray-600">
                    <div>
                        <span class="rounded-lg inline-flex p-3 bg-green-50 text-green-700 ring-4 ring-white dark:bg-green-900/20 dark:text-green-400">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.288 15.038a5.25 5.25 0 017.424 0M5.106 11.856c3.807-3.808 9.98-3.808 13.788 0M1.924 8.674c5.565-5.565 14.587-5.565 20.152 0M12.53 18.22l-.53.53-.53-.53a.75.75 0 011.06 0z" />
                            </svg>
                        </span>
                    </div>
                    <div class="mt-8">
                        <h3 class="text-sm font-medium text-gray-900 dark:text-white">
                            <span class="absolute inset-0" aria-hidden="true"></span>
                            Nova Subscrição
                        </h3>
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                            Criar nova subscrição de internet
                        </p>
                    </div>
                </button>

                <button wire:click="redirectToInvoices" class="relative group bg-white p-6 focus-within:ring-2 focus-within:ring-inset focus-within:ring-blue-500 rounded-lg hover:bg-gray-50 border-2 border-dashed border-gray-300 hover:border-gray-400 dark:bg-gray-700 dark:border-gray-600 dark:hover:bg-gray-600">
                    <div>
                        <span class="rounded-lg inline-flex p-3 bg-yellow-50 text-yellow-700 ring-4 ring-white dark:bg-yellow-900/20 dark:text-yellow-400">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                            </svg>
                        </span>
                    </div>
                    <div class="mt-8">
                        <h3 class="text-sm font-medium text-gray-900 dark:text-white">
                            <span class="absolute inset-0" aria-hidden="true"></span>
                            Gerar Fatura
                        </h3>
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                            Criar nova fatura para cliente
                        </p>
                    </div>
                </button>

                <button wire:click="redirectToTickets" class="relative group bg-white p-6 focus-within:ring-2 focus-within:ring-inset focus-within:ring-blue-500 rounded-lg hover:bg-gray-50 border-2 border-dashed border-gray-300 hover:border-gray-400 dark:bg-gray-700 dark:border-gray-600 dark:hover:bg-gray-600 opacity-50 cursor-not-allowed">
                    <div>
                        <span class="rounded-lg inline-flex p-3 bg-gray-50 text-gray-400 ring-4 ring-white dark:bg-gray-900/20 dark:text-gray-500">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655-4.653a2.548 2.548 0 010-3.586l.837-.836c.317-.317.751-.487 1.204-.487z" />
                            </svg>
                        </span>
                    </div>
                    <div class="mt-8">
                        <h3 class="text-sm font-medium text-gray-400">
                            <span class="absolute inset-0" aria-hidden="true"></span>
                            Nova OS
                        </h3>
                        <p class="mt-2 text-sm text-gray-400">
                            Em breve - Sistema de OS
                        </p>
                    </div>
                </button>
            </div>
        </div>
    </div>
</div>