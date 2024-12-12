<form method="GET" action="{{ route('books.index') }}" class="flex gap-2 items-center my-2">
    <x-ui.form.input placeholder="search..." name="search" value="{{ $search }}" class="text-xs" />
    <x-ui.button variant="yellow" class="text-xs">Search</x-ui.button>
    <x-ui.link variant="light" class="text-xs" href="{{ route('books.index') }}">
        Clear
    </x-ui.link>
</form>
