<x-layout>

    <x-ui.breadcrumb class="my-3" :crumbs="[
        'Home' => route('home'),
        'Books' => route('books.index'),
        $book->id => route('books.show', $book->id),
        'Edit' => '',
    ]" />

    <x-ui.header>
        <h2>Edit Book</h2>
    </x-ui.header>

    <x-ui.card>

        <form method="POST" action="{{ route('books.update', $book->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            @include('books._inputs')

            <div class="mt-4">
                <x-ui.button variant="dark" type="submit">Save</x-ui.button>
                <x-ui.link variant="light" href="{{ route('books.show', $book->id) }}">Cancel</x-ui.link>
            </div>
        </form>
    </x-ui.card>

</x-layout>
