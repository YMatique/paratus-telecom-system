<!DOCTYPE html>
<html lang="pt" x-data="{ sidebarOpen: false }" x-cloak>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Portal do Cliente - Paratus Telecom' }}</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900">
    
    {{-- Header --}}
    <x-customer-portal.header />

    <div class="flex">
        
        {{-- Sidebar --}}
        <x-customer-portal.sidebar />

        {{-- Main Content --}}
        <main class="flex-1 lg:ml-0">
            <div class="p-4 sm:p-6 lg:p-8">
                
                {{-- Breadcrumbs (Opcional) --}}
                @if(isset($breadcrumbs))
                    <nav class="flex mb-6" aria-label="Breadcrumb">
                        <ol class="inline-flex items-center space-x-1 md:space-x-3">
                            @foreach($breadcrumbs as $breadcrumb)
                                <li class="inline-flex items-center">
                                    @if(!$loop->last)
                                        <a href="{{ $breadcrumb['url'] }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                                            {{ $breadcrumb['label'] }}
                                        </a>
                                        <svg class="w-3 h-3 text-gray-400 mx-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    @else
                                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                            {{ $breadcrumb['label'] }}
                                        </span>
                                    @endif
                                </li>
                            @endforeach
                        </ol>
                    </nav>
                @endif

                {{-- Page Content --}}
                {{ $slot }}
            </div>
        </main>
    </div>

    {{-- Toast Notifications --}}
    <div class="fixed top-20 right-4 z-50 space-y-2">
        @if (session('success'))
            <div x-data="{ show: true }" 
                 x-show="show" 
                 x-init="setTimeout(() => show = false, 5000)"
                 x-transition
                 class="bg-white dark:bg-gray-800 border border-green-200 dark:border-green-800 rounded-lg shadow-lg p-4 flex items-start gap-3 max-w-sm">
                <div class="w-10 h-10 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <h4 class="font-semibold text-gray-900 dark:text-white">Sucesso!</h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ session('success') }}</p>
                </div>
                <button @click="show = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        @endif

        @if (session('error'))
            <div x-data="{ show: true }" 
                 x-show="show" 
                 x-init="setTimeout(() => show = false, 5000)"
                 x-transition
                 class="bg-white dark:bg-gray-800 border border-red-200 dark:border-red-800 rounded-lg shadow-lg p-4 flex items-start gap-3 max-w-sm">
                <div class="w-10 h-10 bg-red-100 dark:bg-red-900 rounded-full flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <h4 class="font-semibold text-gray-900 dark:text-white">Erro!</h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ session('error') }}</p>
                </div>
                <button @click="show = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        @endif

        @if (session('warning'))
            <div x-data="{ show: true }" 
                 x-show="show" 
                 x-init="setTimeout(() => show = false, 5000)"
                 x-transition
                 class="bg-white dark:bg-gray-800 border border-yellow-200 dark:border-yellow-800 rounded-lg shadow-lg p-4 flex items-start gap-3 max-w-sm">
                <div class="w-10 h-10 bg-yellow-100 dark:bg-yellow-900 rounded-full flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <h4 class="font-semibold text-gray-900 dark:text-white">Atenção!</h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ session('warning') }}</p>
                </div>
                <button @click="show = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        @endif
    </div>

    @livewireScripts
</body>
</html>