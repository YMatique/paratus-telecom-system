{{-- resources/views/components/toast.blade.php --}}
<div 
    x-data="toastNotification()" 
    x-init="init()"
    class="fixed inset-0 flex items-end justify-center px-4 py-6 pointer-events-none sm:p-6 sm:items-start sm:justify-end z-50"
    style="z-index: 9999;"
>
    <div 
        x-show="show"
        x-transition:enter="transform ease-out duration-300 transition"
        x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
        x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="max-w-sm w-full bg-white shadow-lg rounded-lg pointer-events-auto ring-1 ring-black ring-opacity-5 overflow-hidden dark:bg-gray-800 dark:ring-gray-700"
    >
        <div class="p-4">
            <div class="flex items-start">
                <!-- Ícones por tipo -->
                <div class="flex-shrink-0">
                    <!-- Success -->
                    <template x-if="type === 'success'">
                        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-green-100 dark:bg-green-900/20">
                            <svg class="h-5 w-5 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </template>

                    <!-- Error -->
                    <template x-if="type === 'error'">
                        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-red-100 dark:bg-red-900/20">
                            <svg class="h-5 w-5 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                            </svg>
                        </div>
                    </template>

                    <!-- Warning -->
                    <template x-if="type === 'warning'">
                        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-yellow-100 dark:bg-yellow-900/20">
                            <svg class="h-5 w-5 text-yellow-600 dark:text-yellow-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                            </svg>
                        </div>
                    </template>

                    <!-- Info -->
                    <template x-if="type === 'info'">
                        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900/20">
                            <svg class="h-5 w-5 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                            </svg>
                        </div>
                    </template>
                </div>

                <!-- Conteúdo -->
                <div class="ml-3 w-0 flex-1 pt-0.5">
                    <p x-text="title" class="text-sm font-medium text-gray-900 dark:text-white"></p>
                    <p x-show="message" x-text="message" class="mt-1 text-sm text-gray-500 dark:text-gray-400"></p>
                </div>

                <!-- Botão fechar -->
                <div class="ml-4 flex-shrink-0 flex">
                    <button 
                        @click="hide()"
                        class="bg-white rounded-md inline-flex text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:bg-gray-800 dark:text-gray-500 dark:hover:text-gray-400"
                    >
                        <span class="sr-only">Fechar</span>
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Barra de progresso -->
        <div x-show="showProgress" class="h-1 bg-gray-200 dark:bg-gray-700">
            <div 
                class="h-full transition-all ease-linear"
                :class="{
                    'bg-green-500': type === 'success',
                    'bg-red-500': type === 'error', 
                    'bg-yellow-500': type === 'warning',
                    'bg-blue-500': type === 'info'
                }"
                x-bind:style="'width: ' + progress + '%'"
            ></div>
        </div>
    </div>
</div>

<script>
    function toastNotification() {
        return {
            show: false,
            type: 'success',
            title: '',
            message: '',
            duration: 5000,
            showProgress: true,
            progress: 100,
            progressInterval: null,

            init() {
                // Escutar eventos de toast
                this.$el.addEventListener('toast-show', (e) => {
                    this.showToast(e.detail);
                });

                // Escutar eventos Livewire
                Livewire.on('toast', (data) => {
                    this.showToast(data);
                });

                // Escutar eventos de sessão do Laravel
                @if(session()->has('toast'))
                    this.showToast({
                        type: '{{ session('toast.type', 'success') }}',
                        title: '{{ session('toast.title') }}',
                        message: '{{ session('toast.message', '') }}',
                        duration: {{ session('toast.duration', 5000) }}
                    });
                @endif
            },

            showToast(data) {
                // Reset
                this.clearProgress();
                
                // Definir dados
                this.type = data.type || 'success';
                this.title = data.title || '';
                this.message = data.message || '';
                this.duration = data.duration || 5000;
                this.showProgress = data.showProgress !== false;
                
                // Mostrar toast
                this.show = true;
                this.progress = 100;

                // Iniciar progresso
                if (this.showProgress && this.duration > 0) {
                    this.startProgress();
                }

                // Auto-hide
                if (this.duration > 0) {
                    setTimeout(() => {
                        this.hide();
                    }, this.duration);
                }
            },

            hide() {
                this.show = false;
                this.clearProgress();
            },

            startProgress() {
                const interval = 50; // Update every 50ms
                const decrement = (100 / this.duration) * interval;
                
                this.progressInterval = setInterval(() => {
                    this.progress -= decrement;
                    if (this.progress <= 0) {
                        this.progress = 0;
                        this.clearProgress();
                    }
                }, interval);
            },

            clearProgress() {
                if (this.progressInterval) {
                    clearInterval(this.progressInterval);
                    this.progressInterval = null;
                }
            }
        }
    }

    // Helper global para disparar toasts via JavaScript
    window.toast = {
        success: (title, message = '', options = {}) => {
            window.dispatchEvent(new CustomEvent('toast-show', {
                detail: { type: 'success', title, message, ...options }
            }));
        },
        
        error: (title, message = '', options = {}) => {
            window.dispatchEvent(new CustomEvent('toast-show', {
                detail: { type: 'error', title, message, ...options }
            }));
        },
        
        warning: (title, message = '', options = {}) => {
            window.dispatchEvent(new CustomEvent('toast-show', {
                detail: { type: 'warning', title, message, ...options }
            }));
        },
        
        info: (title, message = '', options = {}) => {
            window.dispatchEvent(new CustomEvent('toast-show', {
                detail: { type: 'info', title, message, ...options }
            }));
        }
    };
</script>