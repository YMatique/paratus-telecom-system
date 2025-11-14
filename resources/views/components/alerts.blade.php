{{-- resources/views/components/alerts.blade.php --}}
@props(['stats'])

<div class="bg-white rounded-lg shadow-md">
    <div class="px-6 py-4 border-b border-gray-200">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-900">Alertas e Pendências</h3>
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                {{ $stats['alerts']['total'] }} alertas
            </span>
        </div>
    </div>
    <div class="px-6 py-4 space-y-4">
        @if($stats['financial']['overdue_count'] > 0)
            <div class="flex items-start space-x-3">
                <div class="w-2 h-2 bg-red-500 rounded-full mt-2"></div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-900">Faturas Vencidas</p>
                    <p class="text-xs text-gray-600">{{ $stats['financial']['overdue_count'] }} faturas em atraso</p>
                </div>
                <a href="{{ route('invoices.index') }}" class="text-xs text-blue-600 hover:text-blue-800">Ver</a>
            </div>
        @endif

        @if($stats['equipment']['low_stock'] > 0)
            <div class="flex items-start space-x-3">
                <div class="w-2 h-2 bg-yellow-500 rounded-full mt-2"></div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-900">Estoque Baixo</p>
                    <p class="text-xs text-gray-600">{{ $stats['equipment']['low_stock'] }} itens críticos</p>
                </div>
                <button class="text-xs text-blue-600 hover:text-blue-800">Ver</button>
            </div>
        @endif

        @if($stats['subscriptions']['pending_installation'] > 0)
            <div class="flex items-start space-x-3">
                <div class="w-2 h-2 bg-blue-500 rounded-full mt-2"></div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-900">Instalações Pendentes</p>
                    <p class="text-xs text-gray-600">{{ $stats['subscriptions']['pending_installation'] }} aguardando</p>
                </div>
                <a href="{{ route('subscriptions.index') }}" class="text-xs text-blue-600 hover:text-blue-800">Ver</a>
            </div>
        @endif
    </div>
</div>