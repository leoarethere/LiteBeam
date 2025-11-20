{{-- File: resources/views/components/stream-modal.blade.php --}}
<turbo-stream action="update" target="flash-container">
    <template>
        {{-- Isi Modal AlpineJS --}}
        <div x-data="{ open: true }" 
             x-show="open"
             x-init="setTimeout(() => open = true, 50)" 
             class="fixed inset-0 z-[70] overflow-y-auto bg-gray-900/75 backdrop-blur-sm flex items-center justify-center p-4">
            
            <div @click.away="open = false"
                 class="relative bg-white rounded-lg shadow-xl dark:bg-gray-800 max-w-sm w-full text-center p-6 border border-gray-100 dark:border-gray-700">

                {{-- Ikon --}}
                @if($type === 'success')
                    <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 dark:bg-green-900/30 mb-5">
                        <svg class="h-8 w-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                @else
                    <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 dark:bg-red-900/30 mb-5">
                        <svg class="h-8 w-8 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </div>
                @endif

                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">{{ $title }}</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">{{ $message }}</p>

                <button @click="open = false" class="w-full px-4 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                    OK, Mengerti
                </button>
            </div>
        </div>
    </template>
</turbo-stream>