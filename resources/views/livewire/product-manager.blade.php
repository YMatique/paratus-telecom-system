<div>
    {{-- Header com estatísticas --}}
    <div class="mb-6">
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center">
                    <div class="p-2 bg-blue-100 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $stats['total'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center">
                    <div class="p-2 bg-green-100 rounded-lg">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Ativos</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $stats['active'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center">
                    <div class="p-2 bg-blue-100 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h14a2 2 0 002-2V8m-9 4h4"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Em Estoque</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $stats['in_stock'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center">
                    <div class="p-2 bg-yellow-100 rounded-lg">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.863-.833-2.633 0L4.232 15.5c-.77.833.192 2.5 1.732 2.5z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Estoque Baixo</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $stats['low_stock'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center">
                    <div class="p-2 bg-red-100 rounded-lg">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Sem Estoque</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $stats['out_of_stock'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center">
                    <div class="p-2 bg-purple-100 rounded-lg">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Valor Total</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['total_value'], 2, ',', '.') }} MT</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Navegação por Tabs --}}
    <div class="mb-6">
        <nav class="flex space-x-8" aria-label="Tabs">
            <button wire:click="setActiveTab('list')" 
                    class="@if($activeTab === 'list') border-indigo-500 text-indigo-600 @else border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 @endif whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                </svg>
                Lista de Produtos
            </button>
            
            <button wire:click="createProduct" 
                    class="@if($activeTab === 'create') border-indigo-500 text-indigo-600 @else border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 @endif whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Novo Produto
            </button>

            @if($activeTab === 'edit' && $selectedProduct)
            <button class="border-indigo-500 text-indigo-600 whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Editar: {{ $selectedProduct->name }}
            </button>
            @endif
        </nav>
    </div>

    {{-- Conteúdo das Tabs --}}
    @if($activeTab === 'list')
        {{-- LISTA DE PRODUTOS --}}
        <div class="bg-white shadow rounded-lg">
            {{-- Filtros e Busca --}}
            <div class="p-4 border-b border-gray-200">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-4 lg:space-y-0">
                    {{-- Busca --}}
                    <div class="flex-1 lg:max-w-md">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <input wire:model.live.debounce.300ms="search" 
                                   type="text" 
                                   class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                                   placeholder="Buscar produtos...">
                        </div>
                    </div>

                    {{-- Filtros --}}
                    <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-2">
                        <select wire:model.live="filterCategory" class="border border-gray-300 rounded-md px-3 py-2 text-sm">
                            <option value="all">Todas Categorias</option>
                            @foreach($categories as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>

                        <select wire:model.live="filterStatus" class="border border-gray-300 rounded-md px-3 py-2 text-sm">
                            <option value="all">Todos Status</option>
                            <option value="active">Ativos</option>
                            <option value="inactive">Inativos</option>
                        </select>

                        <select wire:model.live="filterStock" class="border border-gray-300 rounded-md px-3 py-2 text-sm">
                            <option value="all">Todo Estoque</option>
                            <option value="in_stock">Em Estoque</option>
                            <option value="low_stock">Estoque Baixo</option>
                            <option value="out_of_stock">Sem Estoque</option>
                        </select>
                    </div>
                </div>

                {{-- Bulk Actions --}}
                @if(count($selectedProducts) > 0)
                <div class="mt-4 p-3 bg-blue-50 rounded-md">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-blue-700">
                            {{ count($selectedProducts) }} produto(s) selecionado(s)
                        </span>
                        <div class="space-x-2">
                            <button wire:click="bulkActivate" 
                                    class="inline-flex items-center px-3 py-1 border border-transparent text-xs leading-4 font-medium rounded text-green-700 bg-green-100 hover:bg-green-200">
                                Ativar Selecionados
                            </button>
                            <button wire:click="bulkDeactivate" 
                                    class="inline-flex items-center px-3 py-1 border border-transparent text-xs leading-4 font-medium rounded text-red-700 bg-red-100 hover:bg-red-200">
                                Desativar Selecionados
                            </button>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            {{-- Tabela --}}
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left">
                                <input type="checkbox" wire:click="selectAllProducts" 
                                       class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            </th>
                            <th wire:click="sortBy('name')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100">
                                <div class="flex items-center">
                                    Nome
                                    @if($sortField === 'name')
                                        @if($sortDirection === 'asc')
                                            <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                                            </svg>
                                        @else
                                            <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                            </svg>
                                        @endif
                                    @endif
                                </div>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Categoria</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Marca/Modelo</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Preços</th>
                            <th wire:click="sortBy('stock_quantity')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100">
                                <div class="flex items-center">
                                    Estoque
                                    @if($sortField === 'stock_quantity')
                                        @if($sortDirection === 'asc')
                                            <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                                            </svg>
                                        @else
                                            <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                            </svg>
                                        @endif
                                    @endif
                                </div>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($products as $product)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <input type="checkbox" value="{{ $product->id }}" wire:model.live="selectedProducts" 
                                       class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $product->name }}</div>
                                @if($product->description)
                                    <div class="text-sm text-gray-500 truncate max-w-xs">{{ $product->description }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    @if($product->category === 'modem') bg-blue-100 text-blue-800
                                    @elseif($product->category === 'router') bg-green-100 text-green-800
                                    @elseif($product->category === 'onu') bg-purple-100 text-purple-800
                                    @elseif($product->category === 'antenna') bg-yellow-100 text-yellow-800
                                    @elseif($product->category === 'cable') bg-gray-100 text-gray-800
                                    @else bg-pink-100 text-pink-800 @endif">
                                    {{ $categories[$product->category] ?? $product->category }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                @if($product->brand)
                                    <div class="font-medium">{{ $product->brand }}</div>
                                @endif
                                @if($product->model)
                                    <div class="text-gray-500">{{ $product->model }}</div>
                                @endif
                                @if(!$product->brand && !$product->model)
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                @if($product->sale_price)
                                    <div class="text-green-600 font-medium">Venda: {{ number_format($product->sale_price, 2, ',', '.') }} MT</div>
                                @endif
                                @if($product->rental_price)
                                    <div class="text-blue-600 font-medium">Aluguel: {{ number_format($product->rental_price, 2, ',', '.') }} MT</div>
                                @endif
                                @if(!$product->sale_price && !$product->rental_price)
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <span class="text-sm font-medium text-gray-900 mr-2">{{ $product->stock_quantity }}</span>
                                    @if($product->stock_quantity == 0)
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            Sem estoque
                                        </span>
                                    @elseif($product->isLowStock())
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            Estoque baixo
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Disponível
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($product->is_active)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Ativo
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        Inativo
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-2">
                                    {{-- Controle de Estoque --}}
                                    <div class="relative inline-block text-left" x-data="{ open: false }">
                                        <button @click="open = !open" 
                                                class="inline-flex items-center p-1 border border-transparent rounded-full shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h14a2 2 0 002-2V8m-9 4h4"/>
                                            </svg>
                                        </button>
                                        <div x-show="open" @click.away="open = false" 
                                             class="origin-top-right absolute right-0 mt-2 w-40 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-10">
                                            <div class="py-1" role="menu">
                                                <button wire:click="openStockModal({{ $product->id }}, 'add')" 
                                                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                    Adicionar Estoque
                                                </button>
                                                <button wire:click="openStockModal({{ $product->id }}, 'remove')" 
                                                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                    Remover Estoque
                                                </button>
                                                <button wire:click="openStockModal({{ $product->id }}, 'adjust')" 
                                                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                    Ajustar Estoque
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Editar --}}
                                    <button wire:click="editProduct({{ $product->id }})" 
                                            class="inline-flex items-center p-1 border border-transparent rounded-full shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </button>

                                    {{-- Toggle Status --}}
                                    <button wire:click="toggleStatus({{ $product->id }})" 
                                            class="inline-flex items-center p-1 border border-transparent rounded-full shadow-sm text-white @if($product->is_active) bg-red-600 hover:bg-red-700 focus:ring-red-500 @else bg-green-600 hover:bg-green-700 focus:ring-green-500 @endif focus:outline-none focus:ring-2 focus:ring-offset-2">
                                        @if($product->is_active)
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        @else
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        @endif
                                    </button>

                                    {{-- Menu Actions --}}
                                    <div class="relative inline-block text-left" x-data="{ open: false }">
                                        <button @click="open = !open" 
                                                class="inline-flex items-center p-1 border border-transparent rounded-full shadow-sm text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/>
                                            </svg>
                                        </button>
                                        <div x-show="open" @click.away="open = false" 
                                             class="origin-top-right absolute right-0 mt-2 w-40 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-10">
                                            <div class="py-1" role="menu">
                                                <button wire:click="duplicateProduct({{ $product->id }})" 
                                                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                    Duplicar
                                                </button>
                                                <button wire:click="deleteProduct({{ $product->id }})" 
                                                        onclick="return confirm('Tem certeza que deseja excluir este produto?')"
                                                        class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                                    Excluir
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                Nenhum produto encontrado.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Paginação --}}
            @if($products->hasPages())
            <div class="px-6 py-3 border-t border-gray-200">
                {{ $products->links() }}
            </div>
            @endif
        </div>
    @elseif($activeTab === 'create' || $activeTab === 'edit')
        {{-- FORMULÁRIO DE PRODUTO --}}
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    @if($activeTab === 'create')
                        Novo Produto
                    @else
                        Editar Produto
                    @endif
                </h3>
            </div>

            <form wire:submit="saveProduct" class="p-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Nome --}}
                    <div class="md:col-span-2">
                        <label for="name" class="block text-sm font-medium text-gray-700">Nome do Produto *</label>
                        <input wire:model="name" 
                               type="text" 
                               id="name"
                               class="mt-1 px-3 py-2 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                               placeholder="Ex: Modem ADSL TP-Link">
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Categoria --}}
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700">Categoria *</label>
                        <select wire:model="category" 
                                id="category"
                                class="mt-1 px-3 py-2 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            @foreach($categories as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('category')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Status --}}
                    <div>
                        <label for="is_active" class="block text-sm font-medium text-gray-700">Status</label>
                        <div class="mt-1">
                            <label class="inline-flex items-center">
                                <input wire:model="is_active" 
                                       type="checkbox" 
                                       class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-900">Produto ativo</span>
                            </label>
                        </div>
                    </div>

                    {{-- Marca --}}
                    <div>
                        <label for="brand" class="block text-sm font-medium text-gray-700">Marca</label>
                        <input wire:model="brand" 
                               type="text" 
                               id="brand"
                               class="mt-1 px-3 py-2 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                               placeholder="Ex: TP-Link, Huawei, Mikrotik">
                        @error('brand')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Modelo --}}
                    <div>
                        <label for="model" class="block text-sm font-medium text-gray-700">Modelo</label>
                        <input wire:model="model" 
                               type="text" 
                               id="model"
                               class="mt-1 px-3 py-2 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                               placeholder="Ex: TD-W8961N, HG8245H">
                        @error('model')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Preço de Venda --}}
                    <div>
                        <label for="sale_price" class="block text-sm font-medium text-gray-700">Preço de Venda (MT)</label>
                        <div class="mt-1  relative rounded-md shadow-sm">
                            <input wire:model="sale_price" 
                                   type="number" 
                                   step="0.01" 
                                   min="0"
                                   id="sale_price"
                                   class="block w-full px-3 py-2 pr-8 border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                                   placeholder="0.00">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">MT</span>
                            </div>
                        </div>
                        @error('sale_price')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Preço de Aluguel --}}
                    <div>
                        <label for="rental_price" class="block text-sm font-medium text-gray-700">Preço de Aluguel Mensal (MT)</label>
                        <div class="mt-1  relative rounded-md shadow-sm">
                            <input wire:model="rental_price" 
                                   type="number" 
                                   step="0.01" 
                                   min="0"
                                   id="rental_price"
                                   class="block w-full px-3 py-2 pr-12 border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                                   placeholder="0.00">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">MT</span>
                            </div>
                        </div>
                        @error('rental_price')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Quantidade em Estoque --}}
                    <div>
                        <label for="stock_quantity" class="block text-sm font-medium text-gray-700">Quantidade em Estoque *</label>
                        <input wire:model="stock_quantity" 
                               type="number" 
                               min="0"
                               id="stock_quantity"
                               class="mt-1 px-3 py-2 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                               placeholder="0">
                        @error('stock_quantity')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Alerta de Estoque Mínimo --}}
                    <div>
                        <label for="min_stock_alert" class="block text-sm font-medium text-gray-700">Alerta de Estoque Mínimo *</label>
                        <input wire:model="min_stock_alert" 
                               type="number" 
                               min="1"
                               id="min_stock_alert"
                               class="mt-1 px-3 py-2 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                               placeholder="5">
                        <p class="mt-1 px-3 py-2 text-sm text-gray-500">Você será alertado quando o estoque atingir este valor</p>
                        @error('min_stock_alert')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Descrição --}}
                    <div class="md:col-span-2">
                        <label for="description" class="block text-sm font-medium text-gray-700">Descrição</label>
                        <textarea wire:model="description" 
                                  id="description"
                                  rows="3"
                                  class="mt-1 px-3 py-2 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                                  placeholder="Descrição detalhada do produto, especificações técnicas, etc..."></textarea>
                        @error('description')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Botões --}}
                <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                    <button type="button" 
                            wire:click="setActiveTab('list')"
                            class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Cancelar
                    </button>
                    <button type="submit" 
                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg wire:loading class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        @if($activeTab === 'create')
                            Criar Produto
                        @else
                            Salvar Alterações
                        @endif
                    </button>
                </div>
            </form>
        </div>
    @endif

    {{-- MODAL DE CONTROLE DE ESTOQUE --}}
    @if($showStockModal)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" wire:click="$set('showStockModal', false)"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form wire:submit="updateStock">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full 
                                @if($stockAction === 'add') bg-green-100
                                @elseif($stockAction === 'remove') bg-red-100
                                @else bg-blue-100 @endif
                                sm:mx-0 sm:h-10 sm:w-10">
                                @if($stockAction === 'add')
                                    <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                    </svg>
                                @elseif($stockAction === 'remove')
                                    <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                    </svg>
                                @else
                                    <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                @endif
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                    @if($stockAction === 'add')
                                        Adicionar Estoque
                                    @elseif($stockAction === 'remove')
                                        Remover Estoque
                                    @else
                                        Ajustar Estoque
                                    @endif
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">
                                        Produto: <strong>{{ $selectedProduct->name ?? '' }}</strong><br>
                                        Estoque atual: <strong>{{ $selectedProduct->stock_quantity ?? 0 }} unidades</strong>
                                    </p>
                                </div>
                                <div class="mt-4 space-y-4">
                                    <div>
                                        <label for="stockQuantity" class="block text-sm font-medium text-gray-700">
                                            @if($stockAction === 'add')
                                                Quantidade a adicionar
                                            @elseif($stockAction === 'remove')
                                                Quantidade a remover
                                            @else
                                                Nova quantidade total
                                            @endif
                                        </label>
                                        <input wire:model="stockQuantity" 
                                               type="number" 
                                               min="1" 
                                               id="stockQuantity"
                                               class="mt-1 px-3 py-2 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        @error('stockQuantity')
                                            <p class="mt-1 px-3 py-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="stockReason" class="block text-sm font-medium text-gray-700">Motivo (opcional)</label>
                                        <input wire:model="stockReason" 
                                               type="text" 
                                               id="stockReason"
                                               class="mt-1 px-3 py-2 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                                               placeholder="Ex: Compra, venda, avaria, ajuste de inventário...">
                                        @error('stockReason')
                                            <p class="mt-1 px-3 py-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" 
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 text-base font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm
                                @if($stockAction === 'add') bg-green-600 hover:bg-green-700 focus:ring-green-500
                                @elseif($stockAction === 'remove') bg-red-600 hover:bg-red-700 focus:ring-red-500
                                @else bg-blue-600 hover:bg-blue-700 focus:ring-blue-500 @endif">
                            <svg wire:loading class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Confirmar
                        </button>
                        <button type="button" 
                                wire:click="$set('showStockModal', false)"
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    {{-- Toast Messages --}}
    @if (session()->has('message'))
        <div x-data="{ show: true }" 
             x-show="show" 
             x-transition:enter="transform ease-out duration-300 transition"
             x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
             x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
             x-transition:leave="transition ease-in duration-100"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             x-init="setTimeout(() => show = false, 5000)"
             class="fixed bottom-0 right-0 mb-6 mr-6 z-50">
            <div class="bg-green-500 text-white px-6 py-3 rounded-md shadow-lg">
                <div class="flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ session('message') }}
                </div>
            </div>
        </div>
    @endif

    @if (session()->has('error'))
        <div x-data="{ show: true }" 
             x-show="show" 
             x-transition:enter="transform ease-out duration-300 transition"
             x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
             x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
             x-transition:leave="transition ease-in duration-100"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             x-init="setTimeout(() => show = false, 5000)"
             class="fixed bottom-0 right-0 mb-6 mr-6 z-50">
            <div class="bg-red-500 text-white px-6 py-3 rounded-md shadow-lg">
                <div class="flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ session('error') }}
                </div>
            </div>
        </div>
    @endif
    <script>
    // Alpine.js para dropdowns
    document.addEventListener('alpine:init', () => {
        // Componente já gerenciado pelo Alpine via x-data
    });
</script>
</div>

