<div class="space-y-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Gestão de Clientes</h1>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Gerencie clientes individuais e empresariais</p>
        </div>
        
        @if($activeTab === 'list')
            <button wire:click="createCustomer" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Novo Cliente
            </button>
        @endif
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-gray-800 rounded-lg p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900/20">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Clientes</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 dark:bg-green-900/20">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Ativos</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['active'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 dark:bg-purple-900/20">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Individuais</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['individual'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-orange-100 dark:bg-orange-900/20">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Empresas</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['company'] }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Navegação por Tabs --}}
    <div class="border-b border-gray-200 dark:border-gray-700">
        <nav class="-mb-px flex space-x-8">
            <button wire:click="setActiveTab('list')" 
                class="py-2 px-1 border-b-2 font-medium text-sm {{ $activeTab === 'list' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                Lista de Clientes
            </button>
            @if($activeTab === 'create')
                <button class="py-2 px-1 border-b-2 border-blue-500 text-blue-600 font-medium text-sm">
                    Criar Cliente
                </button>
            @endif
            @if($activeTab === 'edit')
                <button class="py-2 px-1 border-b-2 border-blue-500 text-blue-600 font-medium text-sm">
                    Editar Cliente
                </button>
            @endif
            @if($activeTab === 'view')
                <button class="py-2 px-1 border-b-2 border-blue-500 text-blue-600 font-medium text-sm">
                    Ver Cliente
                </button>
            @endif
            @if($activeTab === 'addresses')
                <button class="py-2 px-1 border-b-2 border-blue-500 text-blue-600 font-medium text-sm">
                    Endereços
                </button>
            @endif
        </nav>
    </div>

    {{-- Conteúdo Principal --}}
    @if($activeTab === 'list')
        {{-- Filtros e Busca --}}
        <div class="bg-white dark:bg-gray-800 rounded-lg p-6 border border-gray-200 dark:border-gray-700">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Buscar</label>
                    <input wire:model.live="search" type="text" placeholder="Nome, email, documento..." 
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tipo</label>
                    <select wire:model.live="filterType" 
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        <option value="all">Todos</option>
                        <option value="individual">Individual</option>
                        <option value="company">Empresa</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                    <select wire:model.live="filterStatus" 
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        <option value="all">Todos</option>
                        <option value="active">Ativo</option>
                        <option value="suspended">Suspenso</option>
                        <option value="inactive">Inativo</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Documento</label>
                    <select wire:model.live="filterDocument" 
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        <option value="all">Todos</option>
                        <option value="bi">BI</option>
                        <option value="nuit">NUIT</option>
                        <option value="passport">Passaporte</option>
                    </select>
                </div>
            </div>

            {{-- Ações em Bulk --}}
            @if(count($selectedCustomers) > 0)
                <div class="flex items-center space-x-4 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg mb-4">
                    <span class="text-sm text-blue-800 dark:text-blue-200">{{ count($selectedCustomers) }} cliente(s) selecionado(s)</span>
                    <button wire:click="bulkActivate" class="text-sm text-green-600 hover:text-green-800">Ativar</button>
                    <button wire:click="bulkSuspend" class="text-sm text-yellow-600 hover:text-yellow-800">Suspender</button>
                    <button wire:click="bulkDeactivate" class="text-sm text-red-600 hover:text-red-800">Desativar</button>
                </div>
            @endif
        </div>

        {{-- Tabela de Clientes --}}
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left">
                                <input type="checkbox" wire:click="selectAllCustomers" 
                                    class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider cursor-pointer" 
                                wire:click="sortBy('name')">
                                <div class="flex items-center space-x-1">
                                    <span>Cliente</span>
                                    @if($sortField === 'name')
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            @if($sortDirection === 'asc')
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            @else
                                                <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd" />
                                            @endif
                                        </svg>
                                    @endif
                                </div>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Documento</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Contato</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tipo</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($customers as $customer)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-6 py-4">
                                    <input type="checkbox" wire:model="selectedCustomers" value="{{ $customer->id }}" 
                                        class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                                <span class="text-sm font-medium text-gray-700">{{ substr($customer->name, 0, 2) }}</span>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $customer->name }}</div>
                                            @if($customer->company_name)
                                                <div class="text-sm text-gray-500 dark:text-gray-400">{{ $customer->company_name }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900 dark:text-white">{{ $customer->document }}</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ strtoupper($customer->document_type) }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($customer->email)
                                        <div class="text-sm text-gray-900 dark:text-white">{{ $customer->email }}</div>
                                    @endif
                                    @if($customer->phone)
                                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ $customer->phone }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $customer->type === 'individual' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                        {{ $customer->type === 'individual' ? 'Individual' : 'Empresa' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $customer->status === 'active' ? 'bg-green-100 text-green-800' : ($customer->status === 'suspended' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                        {{ ucfirst($customer->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right text-sm font-medium">
                                    <div class="flex items-center justify-end space-x-2">
                                        <button wire:click="viewCustomer({{ $customer->id }})" 
                                            class="text-gray-600 hover:text-gray-800 dark:text-gray-400">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </button>
                                        <button wire:click="editCustomer({{ $customer->id }})" 
                                            class="text-blue-600 hover:text-blue-800 dark:text-blue-400">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </button>
                                        <button wire:click="manageAddresses({{ $customer->id }})" 
                                            class="text-purple-600 hover:text-purple-800 dark:text-purple-400">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                        </button>
                                        <button wire:click="deleteCustomer({{ $customer->id }})" 
                                            class="text-red-600 hover:text-red-800 dark:text-red-400"
                                            onclick="return confirm('Tem certeza que deseja excluir este cliente?')">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-12 h-12 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                        </svg>
                                        <p class="text-lg font-medium">Nenhum cliente encontrado</p>
                                        <p class="mt-1">Comece criando seu primeiro cliente</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            {{-- Paginação --}}
            @if($customers->hasPages())
                <div class="px-6 py-3 border-t border-gray-200 dark:border-gray-700">
                    {{ $customers->links() }}
                </div>
            @endif
        </div>

    @elseif($activeTab === 'create' || $activeTab === 'edit')
        {{-- Formulário de Cliente --}}
        <div class="bg-white dark:bg-gray-800 rounded-lg p-6 border border-gray-200 dark:border-gray-700">
            <form wire:submit="saveCustomer">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Tipo de Cliente --}}
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tipo de Cliente *</label>
                        <div class="flex space-x-4">
                            <label class="flex items-center">
                                <input wire:model.live="type" type="radio" value="individual" class="text-blue-600 focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Pessoa Física</span>
                            </label>
                            <label class="flex items-center">
                                <input wire:model.live="type" type="radio" value="company" class="text-blue-600 focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Empresa</span>
                            </label>
                        </div>
                        @error('type') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Nome --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ $type === 'individual' ? 'Nome Completo' : 'Razão Social' }} *
                        </label>
                        <input wire:model="name" type="text" 
                            placeholder="{{ $type === 'individual' ? 'João Silva' : 'Empresa LTDA' }}"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white @error('name') border-red-500 @enderror">
                        @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Nome Fantasia (só para empresa) --}}
                    @if($type === 'company')
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nome Fantasia</label>
                            <input wire:model="company_name" type="text" placeholder="Nome comercial da empresa"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white @error('company_name') border-red-500 @enderror">
                            @error('company_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    @endif

                    {{-- Tipo de Documento --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tipo de Documento *</label>
                        <select wire:model.live="document_type" 
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white @error('document_type') border-red-500 @enderror">
                            <option value="bi">Bilhete de Identidade (BI)</option>
                            <option value="nuit">NUIT</option>
                            <option value="passport">Passaporte</option>
                        </select>
                        @error('document_type') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Número do Documento --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Número do {{ $document_type === 'bi' ? 'BI' : ($document_type === 'nuit' ? 'NUIT' : 'Passaporte') }} *
                        </label>
                        <input wire:model="document" type="text" 
                            placeholder="{{ $document_type === 'bi' ? '123456789' : ($document_type === 'nuit' ? '123456789' : 'A1234567') }}"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white @error('document') border-red-500 @enderror">
                        @error('document') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email</label>
                        <input wire:model="email" type="email" placeholder="cliente@email.com"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white @error('email') border-red-500 @enderror">
                        @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Telefone --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Telefone</label>
                        <input wire:model="phone" type="tel" placeholder="+258 84 123 4567"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white @error('phone') border-red-500 @enderror">
                        @error('phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- WhatsApp --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">WhatsApp</label>
                        <input wire:model="whatsapp" type="tel" placeholder="+258 84 123 4567"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white @error('whatsapp') border-red-500 @enderror">
                        @error('whatsapp') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Status --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status *</label>
                        <select wire:model="status" 
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white @error('status') border-red-500 @enderror">
                            <option value="active">Ativo</option>
                            <option value="suspended">Suspenso</option>
                            <option value="inactive">Inativo</option>
                        </select>
                        @error('status') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Observações --}}
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Observações</label>
                        <textarea wire:model="notes" rows="3" placeholder="Notas adicionais sobre o cliente..."
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white @error('notes') border-red-500 @enderror"></textarea>
                        @error('notes') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Botões de Ação --}}
                <div class="mt-8 flex items-center justify-between">
                    <button type="button" wire:click="setActiveTab('list')" 
                        class="inline-flex items-center px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 font-medium rounded-lg transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Cancelar
                    </button>
                    
                    <button type="submit" 
                        class="inline-flex items-center px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        {{ $activeTab === 'edit' ? 'Atualizar Cliente' : 'Criar Cliente' }}
                    </button>
                </div>
            </form>
        </div>

    @elseif($activeTab === 'view')
        {{-- Visualização do Cliente --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Informações Principais --}}
            <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-lg p-6 border border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Informações do Cliente</h3>
                    <button wire:click="editCustomer({{ $selectedCustomer->id }})" 
                        class="inline-flex items-center px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded-md transition-colors">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Editar
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Nome</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $selectedCustomer->name }}</p>
                    </div>

                    @if($selectedCustomer->company_name)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Nome Fantasia</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $selectedCustomer->company_name }}</p>
                        </div>
                    @endif

                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Tipo</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $selectedCustomer->type === 'individual' ? 'Pessoa Física' : 'Empresa' }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Documento</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $selectedCustomer->document }} ({{ strtoupper($selectedCustomer->document_type) }})</p>
                    </div>

                    @if($selectedCustomer->email)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Email</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $selectedCustomer->email }}</p>
                        </div>
                    @endif

                    @if($selectedCustomer->phone)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Telefone</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $selectedCustomer->phone }}</p>
                        </div>
                    @endif

                    @if($selectedCustomer->whatsapp)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">WhatsApp</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $selectedCustomer->whatsapp }}</p>
                        </div>
                    @endif

                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Status</label>
                        <span class="mt-1 inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $selectedCustomer->status === 'active' ? 'bg-green-100 text-green-800' : ($selectedCustomer->status === 'suspended' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                            {{ ucfirst($selectedCustomer->status) }}
                        </span>
                    </div>
                </div>

                @if($selectedCustomer->notes)
                    <div class="mt-6">
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Observações</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $selectedCustomer->notes }}</p>
                    </div>
                @endif
            </div>

            {{-- Stats Relacionados --}}
            <div class="space-y-4">
                <div class="bg-white dark:bg-gray-800 rounded-lg p-6 border border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Resumo</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500 dark:text-gray-400">Endereços</span>
                            <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $selectedCustomer->addresses->count() }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500 dark:text-gray-400">Subscrições</span>
                            <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $selectedCustomer->subscriptions->count() }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500 dark:text-gray-400">Faturas</span>
                            <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $selectedCustomer->invoices->count() }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500 dark:text-gray-400">Tickets</span>
                            <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $selectedCustomer->tickets->count() }}</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-lg p-6 border border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Ações Rápidas</h3>
                    <div class="space-y-2">
                        <button wire:click="manageAddresses({{ $selectedCustomer->id }})" 
                            class="w-full flex items-center justify-center px-3 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            </svg>
                            Gerenciar Endereços
                        </button>
                        <button class="w-full flex items-center justify-center px-3 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Ver Subscrições
                        </button>
                    </div>
                </div>
            </div>
        </div>

    @elseif($activeTab === 'addresses')
        {{-- Gestão de Endereços --}}
        <div class="space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Endereços de {{ $selectedCustomer->name }}</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Gerencie os endereços do cliente</p>
                </div>
                <button wire:click="createAddress" 
                    class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Novo Endereço
                </button>
            </div>

            {{-- Lista de Endereços --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($selectedCustomer->addresses as $address)
                    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 border border-gray-200 dark:border-gray-700 {{ $address->is_primary ? 'ring-2 ring-blue-500' : '' }}">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center space-x-2">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $address->type === 'installation' ? 'bg-green-100 text-green-800' : ($address->type === 'billing' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800') }}">
                                    {{ $address->type === 'installation' ? 'Instalação' : ($address->type === 'billing' ? 'Cobrança' : 'Correspondência') }}
                                </span>
                                @if($address->is_primary)
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Principal
                                    </span>
                                @endif
                            </div>
                            <div class="flex space-x-1">
                                <button wire:click="editAddress({{ $address->id }})" 
                                    class="text-blue-600 hover:text-blue-800">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </button>
                                <button wire:click="deleteAddress({{ $address->id }})" 
                                    class="text-red-600 hover:text-red-800"
                                    onclick="return confirm('Tem certeza que deseja excluir este endereço?')">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="space-y-2 text-sm">
                            <p class="font-medium text-gray-900 dark:text-white">{{ $address->street }} {{ $address->number }}</p>
                            <p class="text-gray-600 dark:text-gray-400">{{ $address->neighborhood }}</p>
                            <p class="text-gray-600 dark:text-gray-400">{{ $address->district }}, {{ $address->city }}</p>
                            <p class="text-gray-600 dark:text-gray-400">{{ $address->province }}</p>
                            @if($address->postal_code)
                                <p class="text-gray-600 dark:text-gray-400">CEP: {{ $address->postal_code }}</p>
                            @endif
                            @if($address->reference)
                                <p class="text-gray-600 dark:text-gray-400 text-xs">Ref: {{ $address->reference }}</p>
                            @endif
                        </div>

                        @if($address->latitude && $address->longitude)
                            <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                                <a href="https://maps.google.com?q={{ $address->latitude }},{{ $address->longitude }}" 
                                   target="_blank" 
                                   class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    </svg>
                                    Ver no Google Maps
                                </a>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="md:col-span-2 lg:col-span-3 text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">Nenhum endereço cadastrado</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Comece adicionando um endereço para este cliente.</p>
                        <div class="mt-6">
                            <button wire:click="createAddress" 
                                class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Novo Endereço
                            </button>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    @endif

    {{-- Modal de Endereço --}}
    @if($showAddressModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg max-w-2xl w-full max-h-screen overflow-y-auto">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                            {{ $editingAddressId ? 'Editar' : 'Novo' }} Endereço
                        </h3>
                        <button wire:click="$set('showAddressModal', false)" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <form wire:submit="saveAddress">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            {{-- Tipo de Endereço --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tipo de Endereço *</label>
                                <select wire:model="address_type" 
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                    <option value="installation">Instalação</option>
                                    <option value="billing">Cobrança</option>
                                    <option value="correspondence">Correspondência</option>
                                </select>
                                @error('address_type') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            {{-- Endereço Principal --}}
                            <div class="flex items-center mt-6">
                                <input wire:model="is_primary" type="checkbox" id="is_primary" 
                                    class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <label for="is_primary" class="ml-2 text-sm text-gray-700 dark:text-gray-300">Endereço Principal</label>
                            </div>

                            {{-- Rua --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Rua/Avenida *</label>
                                <input wire:model="street" type="text" placeholder="Av. Julius Nyerere" 
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                @error('street') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            {{-- Número --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Número</label>
                                <input wire:model="number" type="text" placeholder="1234" 
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                @error('number') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            {{-- Bairro --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Bairro *</label>
                                <input wire:model="neighborhood" type="text" placeholder="Polana" 
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                @error('neighborhood') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            {{-- Distrito --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Distrito *</label>
                                <input wire:model="district" type="text" placeholder="KaMpfumo" 
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                @error('district') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            {{-- Cidade --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Cidade *</label>
                                <input wire:model="city" type="text" placeholder="Maputo" 
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                @error('city') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            {{-- Província --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Província *</label>
                                <select wire:model="province" 
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                    <option value="">Selecione...</option>
                                    <option value="Maputo">Maputo</option>
                                    <option value="Gaza">Gaza</option>
                                    <option value="Inhambane">Inhambane</option>
                                    <option value="Sofala">Sofala</option>
                                    <option value="Manica">Manica</option>
                                    <option value="Tete">Tete</option>
                                    <option value="Zambézia">Zambézia</option>
                                    <option value="Nampula">Nampula</option>
                                    <option value="Cabo Delgado">Cabo Delgado</option>
                                    <option value="Niassa">Niassa</option>
                                    <option value="Maputo Cidade">Maputo Cidade</option>
                                </select>
                                @error('province') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            {{-- CEP --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Código Postal</label>
                                <input wire:model="postal_code" type="text" placeholder="1100" 
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                @error('postal_code') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            {{-- Latitude --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Latitude</label>
                                <input wire:model="latitude" type="number" step="0.000001" placeholder="-25.966688" 
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                @error('latitude') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            {{-- Longitude --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Longitude</label>
                                <input wire:model="longitude" type="number" step="0.000001" placeholder="32.565473" 
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                @error('longitude') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            {{-- Ponto de Referência --}}
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Ponto de Referência</label>
                                <textarea wire:model="reference" rows="2" placeholder="Próximo ao Hospital Central..." 
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"></textarea>
                                @error('reference') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="mt-6 flex items-center justify-end space-x-4">
                            <button type="button" wire:click="$set('showAddressModal', false)" 
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600">
                                Cancelar
                            </button>
                            <button type="submit" 
                                class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700">
                                {{ $editingAddressId ? 'Atualizar' : 'Salvar' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    {{-- Mensagens de Feedback --}}
    @if (session()->has('message'))
        <div class="fixed bottom-4 right-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg shadow-lg z-50" x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                {{ session('message') }}
            </div>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="fixed bottom-4 right-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg shadow-lg z-50" x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 4000)">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                </svg>
                {{ session('error') }}
            </div>
        </div>
    @endif

    {{-- Loading States --}}
<div wire:loading class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 flex items-center">
        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        <span class="text-gray-700 dark:text-gray-300">Processando...</span>
    </div>
</div>
</div>

