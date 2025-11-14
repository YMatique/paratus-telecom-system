<!DOCTYPE html>
<html lang="pt" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paratus Telecom - Internet Rápida e Confiável</title>
    <meta name="description" content="Provedor de internet fibra óptica em Moçambique. Planos residenciais e empresariais com velocidade até 1 Gbps.">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-white dark:bg-gray-900 text-gray-900 dark:text-white transition-colors">

    {{-- Navbar --}}
    <header class="fixed top-0 left-0 right-0 bg-white/80 dark:bg-gray-900/80 backdrop-blur-md border-b border-gray-200 dark:border-gray-800 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center">
                    <a href="/" class="flex items-center gap-2">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-cyan-500 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <span class="text-xl font-bold text-gray-900 dark:text-white">Paratus Telecom</span>
                    </a>
                </div>

                <nav class="hidden md:flex items-center gap-8">
                    <a href="#planos" class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition">Planos</a>
                    <a href="#cobertura" class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition">Cobertura</a>
                    <a href="#suporte" class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition">Suporte</a>
                    <a href="#sobre" class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition">Sobre</a>
                </nav>

                <div class="flex items-center gap-3">
                    <a href="{{ route('customer.login') }}" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition shadow-md">
                        Área do Cliente
                    </a>
                    <button onclick="document.documentElement.classList.toggle('dark')" class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                        <svg x-show="!document.documentElement.classList.contains('dark')" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                        </svg>
                        <svg x-show="document.documentElement.classList.contains('dark')" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </header>

    {{-- Hero Section --}}
    <section class="pt-24 pb-16 bg-gradient-to-br from-blue-50 to-cyan-50 dark:from-gray-900 dark:to-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-gray-900 dark:text-white leading-tight">
                        Internet <span class="text-blue-600">Fibra Óptica</span><br>
                        Rápida e Confiável
                    </h1>
                    <p class="mt-6 text-lg text-gray-600 dark:text-gray-300">
                        Conecte-se com velocidades de até <strong>1 Gbps</strong>. Ideal para streaming, jogos, home office e toda a família.
                    </p>
                    <div class="mt-8 flex flex-col sm:flex-row gap-4">
                        <a href="#planos" class="inline-flex items-center justify-center px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition shadow-lg">
                            Ver Planos
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10h7L12 3v7zM5 10h7L4 3v7z"/>
                            </svg>
                        </a>
                        <a href="#cobertura" class="inline-flex items-center justify-center px-8 py-3 border-2 border-blue-600 text-blue-600 hover:bg-blue-50 dark:hover:bg-gray-800 font-semibold rounded-lg transition">
                            Verificar Cobertura
                        </a>
                    </div>
                </div>
                <div class="relative">
                    <img src="https://images.unsplash.com/photo-1558494949-ef646e986958?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" alt="Fibra Óptica Paratus" class="rounded-2xl shadow-2xl w-full object-cover">
                    <div class="absolute -bottom-6 -left-6 bg-white dark:bg-gray-800 p-4 rounded-xl shadow-xl">
                        <p class="text-2xl font-bold text-blue-600">+10.000</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Clientes Satisfeitos</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Features --}}
    <section class="py-16 bg-white dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Por que escolher a Paratus?</h2>
                <p class="mt-4 text-lg text-gray-600 dark:text-gray-300">Internet de qualidade com suporte 24/7</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Velocidade Máxima</h3>
                    <p class="text-gray-600 dark:text-gray-300">Até 1 Gbps de download e upload simétrico</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">99,9% de Uptime</h3>
                    <p class="text-gray-600 dark:text-gray-300">Rede redundante e monitoramento 24h</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-purple-100 dark:bg-purple-900 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Suporte Técnico</h3>
                    <p class="text-gray-600 dark:text-gray-300">Atendimento via ticket, WhatsApp e telefone</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Plans Section --}}
    <section id="planos" class="py-16 bg-gray-50 dark:bg-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Nossos Planos</h2>
                <p class="mt-4 text-lg text-gray-600 dark:text-gray-300">Escolha o ideal para sua casa ou empresa</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Plano Residencial -->
                <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg p-8 border border-gray-200 dark:border-gray-700 hover:shadow-xl transition">
                    <h3 class="text-2xl font-bold mb-2">Residencial</h3>
                    <p class="text-4xl font-bold text-blue-600 mb-6">50 Mbps <span class="text-lg font-normal text-gray-600 dark:text-gray-400">/mês</span></p>
                    <ul class="space-y-3 mb-8 text-gray-600 dark:text-gray-300">
                        <li class="flex items-center gap-2"><svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg> 50 Mbps Download</li>
                        <li class="flex items-center gap-2"><svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg> 50 Mbps Upload</li>
                        <li class="flex items-center gap-2"><svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg> Instalação Grátis</li>
                    </ul>
                    <a href="{{ route('customer.register') }}" class="block w-full text-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition">
                        Assinar Agora
                    </a>
                </div>

                <!-- Plano Família -->
                <div class="bg-gradient-to-br from-blue-600 to-blue-700 text-white rounded-2xl shadow-xl p-8 transform scale-105">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-2xl font-bold">Família</h3>
                        <span class="px-3 py-1 bg-white/20 rounded-full text-sm font-medium">Mais Popular</span>
                    </div>
                    <p class="text-5xl font-bold mb-6">100 Mbps <span class="text-xl font-normal">/mês</span></p>
                    <ul class="space-y-3 mb-8">
                        <li class="flex items-center gap-2"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg> 100 Mbps Download</li>
                        <li class="flex items-center gap-2"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg> 100 Mbps Upload</li>
                        <li class="flex items-center gap-2"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg> Wi-Fi 6 Grátis</li>
                        <li class="flex items-center gap-2"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg> Suporte Prioritário</li>
                    </ul>
                    <a href="{{ route('customer.register') }}" class="block w-full text-center px-6 py-3 bg-white text-blue-600 font-semibold rounded-lg hover:bg-gray-100 transition">
                        Assinar Agora
                    </a>
                </div>

                <!-- Plano Empresarial -->
                <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg p-8 border border-gray-200 dark:border-gray-700 hover:shadow-xl transition">
                    <h3 class="text-2xl font-bold mb-2">Empresarial</h3>
                    <p class="text-4xl font-bold text-purple-600 mb-6">500 Mbps <span class="text-lg font-normal text-gray-600 dark:text-gray-400">/mês</span></p>
                    <ul class="space-y-3 mb-8 text-gray-600 dark:text-gray-300">
                        <li class="flex items-center gap-2"><svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg> 500 Mbps Download</li>
                        <li class="flex items-center gap-2"><svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg> IP Fixo Incluído</li>
                        <li class="flex items-center gap-2"><svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg> SLA 99,9%</li>
                    </ul>
                    <a href="tel:+258840000000" class="block w-full text-center px-6 py-3 border-2 border-purple-600 text-purple-600 hover:bg-purple-50 dark:hover:bg-gray-800 font-semibold rounded-lg transition">
                        Falar com Consultor
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-cyan-500 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <span class="text-xl font-bold">Paratus Telecom</span>
                    </div>
                    <p class="text-gray-400">Internet de alta velocidade para Moçambique.</p>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Links Rápidos</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#planos" class="hover:text-white transition">Planos</a></li>
                        <li><a href="#cobertura" class="hover:text-white transition">Cobertura</a></li>
                        <li><a href="{{ route('customer.login') }}" class="hover:text-white transition">Área do Cliente</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Suporte</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="tel:+258840000000" class="hover:text-white transition">+258 84 000 0000</a></li>
                        <li><a href="mailto:suporte@paratus.co.mz" class="hover:text-white transition">suporte@paratus.co.mz</a></li>
                        <li><a href="#" class="hover:text-white transition">WhatsApp</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Redes Sociais</h4>
                    <div class="flex gap-4">
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-blue-600 transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-2.483 1.195a3.95 3.95 0 00-6.775 3.603 11.198 11.198 0 01-8.133-4.123 3.95 3.95 0 001.221 5.273c-.642-.02-1.247-.195-1.775-.486v.05c0 1.906 1.356 3.498 3.158 3.858-.332.09-.682.139-1.042.139-.255 0-.503-.025-.744-.073.503 1.57 1.96 2.71 3.688 2.742a7.927 7.927 0 01-4.912 1.693c-.319 0-.634-.019-.943-.056a11.197 11.197 0 006.07 1.778c7.284 0 11.27-6.035 11.27-11.27 0-.172-.004-.343-.011-.513a8.04 8.04 0 001.977-2.05z"/></svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-blue-600 transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M22.46 6c-.77.35-1.6.58-2.46.69a4.3 4.3 0 001.88-2.37 8.59 8.59 0 01-2.72 1.04 4.27 4.27 0 00-7.28 3.9A12.13 12.13 0 011 4.79a4.27 4.27 0 001.32 5.7c-.68-.02-1.32-.2-1.88-.52v.05a4.3 4.3 0 003.44 4.21 4.3 4.3 0 01-1.93.07 4.28 4.28 0 003.99 2.97 8.59 8.59 0 01-5.32 1.84c-.34 0-.68-.02-1.02-.06a12.14 12.14 0 006.57 1.92c7.88 0 12.18-6.53 12.18-12.18 0-.19-.01-.37-.02-.56a8.7 8.7 0 002.14-2.22z"/></svg>
                        </a>
                    </div>
                </div>
            </div>
            <div class="mt-12 pt-8 border-t border-gray-800 text-center text-gray-400 text-sm">
                © {{ date('Y') }} Paratus Telecom. Todos os direitos reservados.
            </div>
        </div>
    </footer>

    <script>
        // Dark mode toggle persistence
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</body>
</html>