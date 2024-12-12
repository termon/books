<x-ui.header class="mt-3">
    <h2>Authors</h2>
    @can('update', App\Models\Book::class)
        <div class="flex gap-1">
            <!-- custom book method to verify if there are any authors available to add -->
            @if ($book->canAddAuthor())
                <x-ui.link variant="light" href="{{ route('authorbooks.create', $book->id) }}" class="flex gap-1 items-center">
                    <x-ui.svg size="sm" plus />
                    <span>Add</span>
                </x-ui.link>
            @endif
            <!-- custom book method to verify if there are any authors associated with book to remove -->
            @if ($book->canRemoveAuthor())
                <x-ui.link variant="light" href="{{ route('authorbooks.delete', $book->id) }}" class="flex gap-1 items-center">
                    <x-ui.svg size="sm" minus />
                    <span></span>Remove</span>
                </x-ui.link>
            @endif
        </div>
    @endcan
</x-ui.header>

<x-ui.card>
    <div class="flex flex-wrap gap-2 items-center">
        @foreach ($book->authors as $author)
            <x-ui.badge variant="yellow">{{ $author->name }}</x-ui.badge>
        @endforeach
    </div>
</x-ui.card>
