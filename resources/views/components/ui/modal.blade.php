<!-- resources/views/components/modal.blade.php -->

<!-- backdrop -->
<div x-data="{ open: false }" @keydown.escape.window="open=false" x-show="open"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50" style="display: none;"
    @open-modal.window="open=true" @close-modal.window="open = false">

    <!-- Modal -->
    <div x-show="open" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-90"
        x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90"
        class="bg-white w-full max-w-lg p-6 rounded-lg shadow-lg" @click.away="open=false">

        <!-- Modal Header -->
        @isset($title)
            <div class="flex justify-between items-center border-b pb-2 mb-4">
                <h2 class="text-xl font-semibold">{{ $title }}</h2>
                <button @click="open=false" class="text-gray-500 hover:text-gray-800">&times;</button>
            </div>
        @endisset

        <!-- Modal Content -->
        <div class="mb-4">
            {{ $slot }}
        </div>

        <!-- Modal Footer  -->
        @isset($footer)
            <div class="border-t pt-2 mt-4">
                {{ $footer ?? '' }}
            </div>
        @endisset
    </div>

</div>
