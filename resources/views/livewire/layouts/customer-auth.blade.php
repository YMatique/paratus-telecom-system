<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Portal do Cliente - Paratus Telecom' }}</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-gray-900 dark:to-gray-800">
    
    <div class="min-h-screen flex flex-col items-center justify-center p-4">
        
        {{-- Logo --}}
        <div class="mb-8 text-center">
            <a href="/" class="inline-block">
                <div class="flex items-center gap-3">
                    {{-- Logo SVG ou Imagem --}}
                    <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"/>
                        </svg>
                    </div>
                    <div class="text-left">
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Paratus Telecom</h1>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Portal do Cliente</p>
                    </div>
                </div>
            </a>
        </div>

        {{-- Card Principal --}}
        <div class="w-full max-w-md">
            <div class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl overflow-hidden">
                {{ $slot }}
            </div>
        </div>

        {{-- Footer --}}
        <div class="mt-8 text-center text-sm text-gray-600 dark:text-gray-400">
            <p>&copy; {{ date('Y') }} Paratus Telecom. Todos os direitos reservados.</p>
            <div class="mt-2 flex items-center justify-center gap-4">
                <a href="#" class="hover:text-blue-600 transition">Política de Privacidade</a>
                <span>•</span>
                <a href="#" class="hover:text-blue-600 transition">Termos de Uso</a>
                <span>•</span>
                <a href="#" class="hover:text-blue-600 transition">Suporte</a>
            </div>
        </div>
    </div>

    {{-- Toast Notifications (se houver) --}}
    @if (session('success'))
        <div x-data="{ show: true }" 
             x-show="show" 
             x-init="setTimeout(() => show = false, 5000)"
             class="fixed top-4 right-4 z-50 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div x-data="{ show: true }" 
             x-show="show" 
             x-init="setTimeout(() => show = false, 5000)"
             class="fixed top-4 right-4 z-50 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg">
            {{ session('error') }}
        </div>
    @endif

    @livewireScripts
</body>
</html>