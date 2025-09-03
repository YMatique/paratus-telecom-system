<div>
    {{-- Header com estatísticas --}}
    <div class="mb-6">
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center">
                    <div class="p-2 bg-blue-100 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/>
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
                        <p class="text-sm font-medium text-gray-600">Disponíveis</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $stats['available'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center">
                    <div class="p-2 bg-indigo-100 rounded-lg">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Instalados</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $stats['installed'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center">
                    <div class="p-2 bg-yellow-100 rounded-lg">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Manutenção</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $stats['maintenance'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center">
                    <div class="p-2 bg-red-100 rounded-lg">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Avariados</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $stats['damaged'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center">
                    <div class="p-2 bg-gray-100 rounded-lg">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Perdidos</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $stats['lost'] }}</p>
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
                Lista de Equipamentos
            </button>
            
            <button wire:click="createEquipment" 
                    class="@if($activeTab === 'create') border-indigo-500 text-indigo-600 @else border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 @endif whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Novo Equipamento
            </button>

            @if($activeTab === 'edit' && $selectedEquipment)
            <button class="border-indigo-500 text-indigo-600 whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Editar: {{ $selectedEquipment->serial_number }}
            </button>
            @endif
        </nav>
    </div>

    {{-- Conteúdo das Tabs --}}
    @if($activeTab === 'list')
        {{-- LISTA DE EQUIPAMENTOS --}}
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
                                   placeholder="Buscar por serial, MAC, produto, cliente...">
                        </div>
                    </div>

                    {{-- Filtros --}}
                    <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-2">
                        <select wire:model.live="filterProduct" class="border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="all">Todos Produtos</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                        </select>

                        <select wire:model.live="filterStatus" class="border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="all">Todos Status</option>
                            @foreach($statusLabels as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>

                        <select wire:model.live="filterCustomer" class="border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="all">Todos Clientes</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Bulk Actions --}}
                @if(count($selectedEquipments) > 0)
                <div class="mt-4 p-3 bg-blue-50 rounded-md">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-blue-700">
                            {{ count($selectedEquipments) }} equipamento(s) selecionado(s)
                        </span>
                        <div class="space-x-2">
                            <button wire:click="bulkSetAvailable" 
                                    class="inline-flex items-center px-3 py-1 border border-transparent text-xs leading-4 font-medium rounded text-green-700 bg-green-100 hover:bg-green-200">
                                Marcar Disponível
                            </button>
                            <button wire:click="bulkSetMaintenance" 
                                    class="inline-flex items-center px-3 py-1 border border-transparent text-xs leading-4 font-medium rounded text-yellow-700 bg-yellow-100 hover:bg-yellow-200">
                                Enviar Manutenção
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
                                <input type="checkbox" wire:click="selectAllEquipments" 
                                       class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            </th>
                            <th wire:click="sortBy('serial_number')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100">
                                <div class="flex items-center">
                                    Serial/MAC
                                    @if($sortField === 'serial_number')
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
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produto</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cliente</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Datas</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Localização</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($equipments as $equipment)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <input type="checkbox" value="{{ $equipment->id }}" wire:model.live="selectedEquipments" 
                                       class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $equipment->serial_number }}</div>
                                @if($equipment->mac_address)
                                    <div class="text-sm text-gray-500">MAC: {{ chunk_split($equipment->mac_address, 2, ':') }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $equipment->product->name }}</div>
                                @if($equipment->product->brand || $equipment->product->model)
                                    <div class="text-sm text-gray-500">
                                        {{ $equipment->product->brand }} {{ $equipment->product->model }}
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    @if($equipment->status === 'available') bg-green-100 text-green-800
                                    @elseif($equipment->status === 'installed') bg-blue-100 text-blue-800
                                    @elseif($equipment->status === 'maintenance') bg-yellow-100 text-yellow-800
                                    @elseif($equipment->status === 'damaged') bg-red-100 text-red-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ $statusLabels[$equipment->status] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($equipment->customer)
                                    <div class="text-sm font-medium text-gray-900">{{ $equipment->customer->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $equipment->customer->document }}</div>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                @if($equipment->installation_date)
                                    <div class="text-green-600">Instalação: {{ $equipment->installation_date->format('d/m/Y') }}</div>
                                @endif
                                @if($equipment->return_date)
                                    <div class="text-blue-600">Retorno: {{ $equipment->return_date->format('d/m/Y') }}</div>
                                @endif
                                @if(!$equipment->installation_date && !$equipment->return_date)
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($equipment->location_notes)
                                    <div class="text-sm text-gray-900 truncate max-w-xs" title="{{ $equipment->location_notes }}">
                                        {{ $equipment->location_notes }}
                                    </div>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-2">
                                    {{-- Ações Rápidas --}}
                                    <div class="relative inline-block text-left" x-data="{ open: false }">
                                        <button @click="open = !open" 
                                                class="inline-flex items-center p-1 border border-transparent rounded-full shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                            </svg>
                                        </button>
                                        <div x-show="open" @click.away="open = false" 
                                             class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-10">
                                            <div class="py-1" role="menu">
                                                @if($equipment->status === 'available')
                                                    <button wire:click="openActionModal({{ $equipment->id }}, 'install')" 
                                                            class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                                        </svg>
                                                        Instalar
                                                    </button>
                                                @endif
                                                
                                                @if($equipment->status === 'installed')
                                                    <button wire:click="openActionModal({{ $equipment->id }}, 'return')" 
                                                            class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                                                        </svg>
                                                        Retornar
                                                    </button>
                                                @endif
                                                
                                                @if(in_array($equipment->status, ['available', 'installed']))
                                                    <button wire:click="openActionModal({{ $equipment->id }}, 'maintenance')" 
                                                            class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                        </svg>
                                                        Manutenção
                                                    </button>
                                                @endif
                                                
                                                <button wire:click="openActionModal({{ $equipment->id }}, 'damage')" 
                                                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                    Marcar Avariado
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Editar --}}
                                    <button wire:click="editEquipment({{ $equipment->id }})" 
                                            class="inline-flex items-center p-1 border border-transparent rounded-full shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </button>

                                    {{-- Excluir --}}
                                    <button wire:click="deleteEquipment({{ $equipment->id }})" 
                                            onclick="return confirm('Tem certeza que deseja excluir este equipamento?')"
                                            class="inline-flex items-center p-1 border border-transparent rounded-full shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                Nenhum equipamento encontrado.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Paginação --}}
            @if($equipments->hasPages())
            <div class="px-6 py-3 border-t border-gray-200">
                {{ $equipments->links() }}
            </div>
            @endif
        </div>
    @elseif($activeTab === 'create' || $activeTab === 'edit')
        {{-- FORMULÁRIO DE EQUIPAMENTO --}}
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    @if($activeTab === 'create')
                        Novo Equipamento
                    @else
                        Editar Equipamento
                    @endif
                </h3>
            </div>

            <form wire:submit="saveEquipment" class="p-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Produto --}}
                    <div>
                        <label for="product_id" class="block text-sm font-medium text-gray-700">Produto *</label>
                        <select wire:model="product_id" 
                                id="product_id"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="">Selecione um produto</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }} - {{ $product->brand }} {{ $product->model }}</option>
                            @endforeach
                        </select>
                        @error('product_id')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Status --}}
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Status *</label>
                        <select wire:model="status" 
                                id="status"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            @foreach($statusLabels as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('status')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Número de Série --}}
                    <div>
                        <label for="serial_number" class="block text-sm font-medium text-gray-700">Número de Série *</label>
                        <input wire:model="serial_number" 
                               type="text" 
                               id="serial_number"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm uppercase" 
                               placeholder="Ex: SN123456789">
                        @error('serial_number')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Endereço MAC --}}
                    <div>
                        <label for="mac_address" class="block text-sm font-medium text-gray-700">Endereço MAC</label>
                        <input wire:model="mac_address" 
                               type="text" 
                               id="mac_address"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm uppercase" 
                               placeholder="Ex: 00:11:22:33:44:55">
                        <p class="mt-1 text-sm text-gray-500">Formato: XX:XX:XX:XX:XX:XX ou XX-XX-XX-XX-XX-XX</p>
                        @error('mac_address')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Cliente (só se instalado) --}}
                    @if($status === 'installed')
                    <div>
                        <label for="customer_id" class="block text-sm font-medium text-gray-700">Cliente</label>
                        <select wire:model="customer_id" 
                                id="customer_id"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="">Selecione um cliente</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->name }} - {{ $customer->document }}</option>
                            @endforeach
                        </select>
                        @error('customer_id')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    @endif

                    {{-- Data de Instalação --}}
                    @if(in_array($status, ['installed']))
                    <div>
                        <label for="installation_date" class="block text-sm font-medium text-gray-700">Data de Instalação</label>
                        <input wire:model="installation_date" 
                               type="date" 
                               id="installation_date"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @error('installation_date')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    @endif

                    {{-- Data de Retorno --}}
                    @if(in_array($status, ['available']) && $selectedEquipment && $selectedEquipment->installation_date)
                    <div>
                        <label for="return_date" class="block text-sm font-medium text-gray-700">Data de Retorno</label>
                        <input wire:model="return_date" 
                               type="date" 
                               id="return_date"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @error('return_date')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    @endif

                    {{-- Observações de Localização --}}
                    <div class="md:col-span-2">
                        <label for="location_notes" class="block text-sm font-medium text-gray-700">Observações / Localização</label>
                        <textarea wire:model="location_notes" 
                                  id="location_notes"
                                  rows="3"
                                  class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                                  placeholder="Ex: Casa do cliente, Rua X, nº 123, próximo ao posto de gasolina..."></textarea>
                        @error('location_notes')
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
                            Cadastrar Equipamento
                        @else
                            Salvar Alterações
                        @endif
                    </button>
                </div>
            </form>
        </div>
    @endif

    {{-- MODAL DE AÇÕES RÁPIDAS --}}
    @if($showActionModal)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" wire:click="$set('showActionModal', false)"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form wire:submit="executeAction">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full 
                                @if($actionType === 'install') bg-blue-100
                                @elseif($actionType === 'return') bg-green-100
                                @elseif($actionType === 'maintenance') bg-yellow-100
                                @else bg-red-100 @endif
                                sm:mx-0 sm:h-10 sm:w-10">
                                @if($actionType === 'install')
                                    <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                @elseif($actionType === 'return')
                                    <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                                    </svg>
                                @elseif($actionType === 'maintenance')
                                    <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                @else
                                    <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                @endif
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                    @if($actionType === 'install')
                                        Instalar Equipamento
                                    @elseif($actionType === 'return')
                                        Retornar Equipamento
                                    @elseif($actionType === 'maintenance')
                                        Enviar para Manutenção
                                    @else
                                        Marcar como Avariado
                                    @endif
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">
                                        Equipamento: <strong>{{ $selectedEquipment->product->name ?? '' }}</strong><br>
                                        Serial: <strong>{{ $selectedEquipment->serial_number ?? '' }}</strong>
                                    </p>
                                </div>
                                <div class="mt-4 space-y-4">
                                    {{-- Cliente (só para instalação) --}}
                                    @if($actionType === 'install')
                                    <div>
                                        <label for="actionCustomer" class="block text-sm font-medium text-gray-700">Cliente *</label>
                                        <select wire:model="actionCustomer" 
                                                id="actionCustomer"
                                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                            <option value="">Selecione um cliente</option>
                                            @foreach($customers as $customer)
                                                <option value="{{ $customer->id }}">{{ $customer->name }} - {{ $customer->document }}</option>
                                            @endforeach
                                        </select>
                                        @error('actionCustomer')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    @endif

                                    {{-- Data --}}
                                    <div>
                                        <label for="actionDate" class="block text-sm font-medium text-gray-700">
                                            @if($actionType === 'install')
                                                Data de Instalação *
                                            @elseif($actionType === 'return')
                                                Data de Retorno *
                                            @else
                                                Data *
                                            @endif
                                        </label>
                                        <input wire:model="actionDate" 
                                               type="date" 
                                               id="actionDate"
                                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        @error('actionDate')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    {{-- Observações --}}
                                    <div>
                                        <label for="actionNotes" class="block text-sm font-medium text-gray-700">
                                            @if($actionType === 'install')
                                                Localização / Observações
                                            @elseif($actionType === 'return')
                                                Motivo do Retorno
                                            @elseif($actionType === 'maintenance')
                                                Descrição do Problema
                                            @else
                                                Descrição da Avaria
                                            @endif
                                        </label>
                                        <textarea wire:model="actionNotes" 
                                                  id="actionNotes"
                                                  rows="3"
                                                  class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                                                  placeholder="@if($actionType === 'install')Endereço da instalação, observações...@elseif($actionType === 'return')Motivo do retorno...@elseif($actionType === 'maintenance')Problema relatado, sintomas...@elseDescreva a avaria encontrada...@endif"></textarea>
                                        @error('actionNotes')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" 
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 text-base font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm
                                @if($actionType === 'install') bg-blue-600 hover:bg-blue-700 focus:ring-blue-500
                                @elseif($actionType === 'return') bg-green-600 hover:bg-green-700 focus:ring-green-500
                                @elseif($actionType === 'maintenance') bg-yellow-600 hover:bg-yellow-700 focus:ring-yellow-500
                                @else bg-red-600 hover:bg-red-700 focus:ring-red-500 @endif">
                            <svg wire:loading class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Confirmar
                        </button>
                        <button type="button" 
                                wire:click="$set('showActionModal', false)"
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

