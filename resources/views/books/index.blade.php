<x-layout>

    <x-ui.breadcrumb class="my-3" :crumbs="[
        'Home' => route('home'),
        'Books' => '',
    ]" />

    <x-ui.header>
        <h1>Books</h1>
        @can('create', App\Models\Book::class)
            <x-ui.link variant="light" href="{{ route('books.create') }}" class="flex gap-1 items-center">
                <x-ui.svg plus size="sm" />
                <span>Create </span>
            </x-ui.link>
        @endcan
    </x-ui.header>


    @include('books._search')

    <x-ui.card>
        <table class="table">
            <thead>
                <tr>
                    <th>
                        <x-ui.link-sort name="id">Id</x-ui.link-sort>
                    </th>
                    <th>
                        <x-ui.link-sort name="title">Title</x-ui.link-sort>
                    </th>
                    <th>
                        <x-ui.link-sort name="rating">Rating</x-ui.link-sort>
                    </th>
                    <th>
                        <x-ui.link-sort name="category.name">Category</x-ui.link-sort>

                    </th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($books as $book)
                    <tr>
                        <td>{{ $book->id }}</td>
                        <td>{{ $book->title }}</td>
                        <td>{{ $book->rating }}</td>
                        <td>{{ $book->category->name }}</td>
                        <td>
                            <x-ui.link variant="slink" href="{{ route('books.show', $book->id) }}"
                                class="flex gap-1 items-center">
                                <x-ui.svg info />
                                <span>View</span>
                            </x-ui.link>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </x-ui.card>

    <!-- TBC Pagination Links -->
    <div class="mt-2">
        {{ $books->links() }}
    </div>

</x-layout>
