{{-- resources/views/components/dashboard-kpi.blade.php --}}
@props([
    'title',
    'value',
    'growth' => null,
    'growthPositive' => null,
    'icon',
    'color' => 'blue',
    'footer' => null
])

<div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-{{ $color }}-500">
    <div class="flex items-center">
        <div class="flex-shrink-0">
            <div class="w-12 h-12 bg-{{ $color }}-100 rounded-lg flex items-center justify-center">
                @switch($icon)
                    @case('users')
                        <svg class="w-6 h-6 text-{{ $color }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        @break
                    @case('signal')
                        <svg class="w-6 h-6 text-{{ $color }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"/>
                        </svg>
                        @break
                    @case('currency')
                        <svg class="w-6 h-6 text-{{ $color }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                        </svg>
                        @break
                    @case('support')
                        <svg class="w-6 h-6 text-{{ $color }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M12 2.25a9.75 9.75 0 11-9.75 9.75A9.75 9.75 0 0112 2.25z"/>
                        </svg>
                        @break
                @endswitch
            </div>
        </div>
        <div class="ml-4 flex-1">
            <h3 class="text-sm font-medium text-gray-500">{{ $title }}</h3>
            <div class="flex items-baseline">
                <p class="text-2xl font-semibold text-gray-900">{{ $value }}</p>
                @if($growth !== null)
                    <span class="ml-2 text-sm font-medium {{ $growthPositive ? 'text-green-600' : 'text-red-600' }}">
                        {{ $growthPositive ? '+' : '' }}{{ $growth }}%
                    </span>
                @endif
            </div>
            @if($footer)
                <p class="text-xs text-gray-500 mt-1">{{ $footer }}</p>
            @endif
        </div>
    </div>
</div>