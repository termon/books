<!-- views/authorbook/create.blade.php -->

<x-layout>

    <x-ui.breadcrumb class="my-3" :crumbs="[
        'Home' => route('home'),
        'Books' => route('books.index'),
        $book->id => route('books.show', $book->id),
        'Remove Author' => '',
    ]" />

    <x-ui.header>
        <h2>Remove Author from {{ $book->title }}</h2>
    </x-ui.header>

    <x-ui.card>
        <form method="POST" action="{{ route('authorbooks.destroy', ['id' => $book->id]) }}">
            @csrf
            @method('DELETE')

            <div class="mt-2">
                <x-ui.form.select label="Author" name="author_id" value="{{ old('author_id') }}" :options="$authors" />
            </div>
            <div class="flex items-center gap-2 mt-2">
                <x-ui.button variant="dark">Remove</x-ui.button>
                <x-ui.link href="{{ route('books.show', $book->id) }}">
                    Cancel
                </x-ui.link>
            </div>
        </form>
    </x-ui.card>
</x-layout>
