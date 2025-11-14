{{-- resources/views/components/recent-activity.blade.php --}}
@props([
    'title',
    'items' => [],
    'type' => 'customer' // 'customer' ou 'ticket'
])

<div class="bg-white rounded-lg shadow-md">
    <div class="px-6 py-4 border-b border-gray-200">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-900">{{ $title }}</h3>
            @if($items->count() > 0)
                <a href="{{ $type === 'customer' ? route('customers.index') : route('tickets.index') }}"
                   class="text-sm text-blue-600 hover:text-blue-800">Ver todos</a>
            @endif
        </div>
    </div>
    <div class="px-6 py-4">
        @if($items->count() > 0)
            <div class="space-y-4">
                @foreach($items as $item)
                    @if($type === 'customer')
                        <div class="flex items-center space-x-4">
                            <div class="w-10 h-10 bg-{{ $item['status_color'] }}-100 rounded-full flex items-center justify-center">
                                <span class="text-sm font-medium text-{{ $item['status_color'] }}-600">{{ $item['initials'] }}</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ $item['name'] }}</p>
                                <p class="text-xs text-gray-500">{{ $item['email'] }}</p>
                            </div>
                            <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full bg-{{ $item['status_color'] }}-100 text-{{ $item['status_color'] }}-800">
                                {{ $item['status_label'] }}
                            </span>
                        </div>
                    @else
                        <div class="flex items-center justify-between">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ $item['subject'] }}</p>
                                <p class="text-xs text-gray-500">{{ $item['customer'] }} • {{ $item['created_at'] }}</p>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $item['priority_color'] }}-100 text-{{ $item['priority_color'] }}-800">
                                {{ $item['priority_label'] }}
                            </span>
                        </div>
                    @endif
                @endforeach
            </div>
        @else
            <div class="text-center py-8">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                </svg>
                <p class="mt-2 text-sm text-gray-600">
                    {{ $type === 'customer' ? 'Nenhum cliente recente' : 'Nenhum ticket aberto' }}
                </p>
            </div>
        @endif
    </div>
</div>