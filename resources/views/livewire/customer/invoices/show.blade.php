<div>
    {{-- Breadcrumb --}}
    <nav class="flex mb-6" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('customer.invoices.index') }}" 
                   wire:navigate
                   class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                    Faturas
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-3 h-3 text-gray-400 mx-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">
                        {{ $invoice->invoice_number }}
                    </span>
                </div>
            </li>
        </ol>
    </nav>

    {{-- Header with Actions --}}
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                Fatura {{ $invoice->invoice_number }}
            </h1>
            <p class="mt-1 text-gray-600 dark:text-gray-400">
                Emitida em {{ $invoice->created_at->format('d/m/Y') }}
            </p>
        </div>

        <div class="flex flex-wrap gap-2">
            <button 
                wire:click="downloadPdf"
                class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Download PDF
            </button>
            
            <button 
                wire:click="printInvoice"
                class="inline-flex items-center gap-2 px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                Imprimir
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- Fatura Principal --}}
        <div class="lg:col-span-2 space-y-6">
            
            {{-- Status Card --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-1">Status da Fatura</h3>
                        <span class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-full
                            @if($invoice->status === 'paid') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                            @elseif($invoice->status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300
                            @elseif($invoice->status === 'overdue') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300
                            @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300
                            @endif">
                            @if($invoice->status === 'paid')
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Paga
                            @elseif($invoice->status === 'pending')
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Pendente
                            @elseif($invoice->status === 'overdue')
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Vencida
                            @else
                                {{ ucfirst($invoice->status) }}
                            @endif
                        </span>
                    </div>
                    
                    @if($invoice->status !== 'paid')
                        <button 
                            wire:click="reportPayment"
                            class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition">
                            Informar Pagamento
                        </button>
                    @endif
                </div>

                <div class="mt-6 grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-gray-600 dark:text-gray-400 mb-1">Data de Emissão</p>
                        <p class="font-medium text-gray-900 dark:text-white">
                            {{ $invoice->created_at->format('d/m/Y') }}
                        </p>
                    </div>
                    <div>
                        <p class="text-gray-600 dark:text-gray-400 mb-1">Data de Vencimento</p>
                        <p class="font-medium {{ $invoice->status === 'overdue' ? 'text-red-600 dark:text-red-400' : 'text-gray-900 dark:text-white' }}">
                            {{ $invoice->due_date->format('d/m/Y') }}
                            @if($invoice->status === 'overdue')
                                <span class="block text-xs">
                                    ({{ $invoice->due_date->diffForHumans() }})
                                </span>
                            @endif
                        </p>
                    </div>
                    @if($invoice->paid_at)
                        <div>
                            <p class="text-gray-600 dark:text-gray-400 mb-1">Data de Pagamento</p>
                            <p class="font-medium text-green-600 dark:text-green-400">
                                {{ $invoice->paid_at->format('d/m/Y') }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Itens da Fatura --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Itens da Fatura</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 dark:bg-gray-700/50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">Descrição</th>
                                <th class="px-6 py-3 text-right text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">Qtd</th>
                                <th class="px-6 py-3 text-right text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">Preço Unit.</th>
                                <th class="px-6 py-3 text-right text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($invoice->invoiceItems as $item)
                                <tr>
                                    <td class="px-6 py-4">
                                        <p class="font-medium text-gray-900 dark:text-white">{{ $item->description }}</p>
                                        @if($item->notes)
                                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $item->notes }}</p>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right text-gray-900 dark:text-white">
                                        {{ $item->quantity }}
                                    </td>
                                    <td class="px-6 py-4 text-right text-gray-900 dark:text-white">
                                        {{ number_format($item->unit_price, 2, ',', '.') }} MT
                                    </td>
                                    <td class="px-6 py-4 text-right font-semibold text-gray-900 dark:text-white">
                                        {{ number_format($item->total_price, 2, ',', '.') }} MT
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gray-50 dark:bg-gray-700/50">
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-right font-semibold text-gray-900 dark:text-white">
                                    Subtotal:
                                </td>
                                <td class="px-6 py-4 text-right font-semibold text-gray-900 dark:text-white">
                                    {{ number_format($invoice->subtotal, 2, ',', '.') }} MT
                                </td>
                            </tr>
                            @if($invoice->tax_amount > 0)
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-right text-gray-700 dark:text-gray-300">
                                        IVA ({{ $invoice->tax_rate }}%):
                                    </td>
                                    <td class="px-6 py-4 text-right text-gray-900 dark:text-white">
                                        {{ number_format($invoice->tax_amount, 2, ',', '.') }} MT
                                    </td>
                                </tr>
                            @endif
                            @if($invoice->discount_amount > 0)
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-right text-green-600 dark:text-green-400">
                                        Desconto:
                                    </td>
                                    <td class="px-6 py-4 text-right text-green-600 dark:text-green-400">
                                        -{{ number_format($invoice->discount_amount, 2, ',', '.') }} MT
                                    </td>
                                </tr>
                            @endif
                            <tr class="border-t-2 border-gray-300 dark:border-gray-600">
                                <td colspan="3" class="px-6 py-4 text-right text-lg font-bold text-gray-900 dark:text-white">
                                    TOTAL:
                                </td>
                                <td class="px-6 py-4 text-right text-lg font-bold text-gray-900 dark:text-white">
                                    {{ number_format($invoice->total_amount, 2, ',', '.') }} MT
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            {{-- Notas --}}
            @if($invoice->notes)
                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-6">
                    <h4 class="font-semibold text-blue-900 dark:text-blue-200 mb-2">Observações</h4>
                    <p class="text-sm text-blue-800 dark:text-blue-300">{{ $invoice->notes }}</p>
                </div>
            @endif
        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">
            
            {{-- Info da Subscrição --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Subscrição</h3>
                <div class="space-y-3 text-sm">
                    <div>
                        <p class="text-gray-600 dark:text-gray-400 mb-1">Plano</p>
                        <p class="font-medium text-gray-900 dark:text-white">
                            {{ $invoice->subscription->plan->name }}
                        </p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            {{ $invoice->subscription->plan->download_speed }}MB / 
                            {{ $invoice->subscription->plan->upload_speed }}MB
                        </p>
                    </div>
                    <div>
                        <p class="text-gray-600 dark:text-gray-400 mb-1">Endereço</p>
                        <p class="text-gray-900 dark:text-white">
                            {{ $invoice->subscription->installationAddress->full_address ?? 'N/A' }}
                        </p>
                    </div>
                </div>
                <a href="{{ route('customer.subscriptions.show', $invoice->subscription->id) }}" 
                   wire:navigate
                   class="mt-4 block w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-center font-medium rounded-lg transition">
                    Ver Subscrição
                </a>
            </div>

            {{-- Histórico de Pagamentos --}}
            @if($invoice->payments->count() > 0)
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Pagamentos</h3>
                    <div class="space-y-3">
                        @foreach($invoice->payments as $payment)
                            <div class="flex items-center justify-between text-sm p-3 bg-green-50 dark:bg-green-900/20 rounded-lg">
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-white">
                                        {{ number_format($payment->amount, 2, ',', '.') }} MT
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $payment->payment_date->format('d/m/Y') }}
                                    </p>
                                </div>
                                <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300 rounded-full">
                                    {{ ucfirst($payment->payment_method) }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Ajuda --}}
            <div class="bg-purple-50 dark:bg-purple-900/20 border border-purple-200 dark:border-purple-800 rounded-xl p-6">
                <h4 class="font-semibold text-purple-900 dark:text-purple-200 mb-2">Dúvidas sobre sua fatura?</h4>
                <p class="text-sm text-purple-800 dark:text-purple-300 mb-4">
                    Nossa equipe está pronta para ajudar
                </p>
                <a href="{{ route('customer.tickets.create') }}" 
                   wire:navigate
                   class="block w-full px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white text-center font-medium rounded-lg transition">
                    Abrir Ticket
                </a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('print-invoice', () => {
            window.print();
        });
    });
</script>
@endpush