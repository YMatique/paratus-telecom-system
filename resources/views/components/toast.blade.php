{{-- resources/views/components/toast.blade.php --}}
<div 
    x-data="{ 
        show: false, 
        type: 'success', 
        title: '', 
        message: '',
        
        showToast(data) {
            this.type = data.type || 'success';
            this.title = data.title || '';
            this.message = data.message || '';
            this.show = true;
            
            log(data);
            // Auto hide after 5 seconds
            setTimeout(() => { this.show = false }, 5000);
        }
    }"
    x-on:toast.window="showToast($event.detail)"
    x-show="show"
    x-transition:enter="transform ease-out duration-300 transition"
    x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
    x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
    x-transition:leave="transition ease-in duration-100"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed top-4 right-4 max-w-sm w-full bg-white shadow-lg rounded-lg pointer-events-auto ring-1 ring-black ring-opacity-5 overflow-hidden z-50 dark:bg-gray-800 dark:ring-gray-700"
    style="display: none;"
>
    <div class="p-4">
        <div class="flex items-start">
            <!-- Ícone -->
            <div class="flex-shrink-0">
                <!-- Success -->
                <svg x-show="type === 'success'" class="h-6 w-6 text-green-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                
                <!-- Error -->
                <svg x-show="type === 'error'" class="h-6 w-6 text-red-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                </svg>
                
                <!-- Warning -->
                <svg x-show="type === 'warning'" class="h-6 w-6 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                </svg>
                
                <!-- Info -->
                <svg x-show="type === 'info'" class="h-6 w-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                </svg>
            </div>

            <!-- Conteúdo -->
            <div class="ml-3 w-0 flex-1 pt-0.5">
                <p x-text="title" class="text-sm font-medium text-gray-900 dark:text-white"></p>
                <p x-show="message" x-text="message" class="mt-1 text-sm text-gray-500 dark:text-gray-400"></p>
            </div>

            <!-- Botão fechar -->
            <div class="ml-4 flex-shrink-0 flex">
                <button 
                    @click="show = false"
                    class="bg-white rounded-md inline-flex text-gray-400 hover:text-gray-500 focus:outline-none dark:bg-gray-800"
                >
                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Mostrar toast se houver na sessão --}}
@if(session()->has('toast'))
<script>
    document.addEventListener('alpine:init', () => {
        setTimeout(() => {
            window.dispatchEvent(new CustomEvent('toast', {
                detail: {
                    type: '{{ session('toast.type', 'success') }}',
                    title: '{{ session('toast.title') }}',
                    message: '{{ session('toast.message', '') }}'
                }
            }));
        }, 100);
    });
</script>
@endif

<script>
    // Helper global para JavaScript
    window.toast = {
        success: (title, message = '') => {
            window.dispatchEvent(new CustomEvent('toast', {
                detail: { type: 'success', title, message }
            }));
        },
        error: (title, message = '') => {
            window.dispatchEvent(new CustomEvent('toast', {
                detail: { type: 'error', title, message }
            }));
        },
        warning: (title, message = '') => {
            window.dispatchEvent(new CustomEvent('toast', {
                detail: { type: 'warning', title, message }
            }));
        },
        info: (title, message = '') => {
            window.dispatchEvent(new CustomEvent('toast', {
                detail: { type: 'info', title, message }
            }));
        }
    };
</script>