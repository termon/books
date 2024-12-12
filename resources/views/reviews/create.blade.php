<x-layout>

    <x-ui.breadcrumb class="my-3" :crumbs="[
        'Home' => route('home'),
        'Books' => route('books.index'),
        $review->book_id => route('books.show', $review->book_id),
        'Add Review' => '',
    ]" />

    <x-ui.header>
        <h2>Add Review</h2>
    </x-ui.header>

    <x-ui.card>

        <form method="POST" action="{{ route('reviews.store', $review->book_id) }}">
            @csrf

            <div class="mt-2">
                <x-ui.form.input label="Name" name="name" type="text" value="{{ old('name', $review->name) }}" />
            </div>

            <div class="mt-2">
                <x-ui.form.input label="Rating" name="rating" type="number"
                    value="{{ old('rating', $review->rating) }}" />
            </div>

            <div class="mt-2">
                <x-ui.form.textarea label="Comment" name="comment" value="{{ old('comment', $review->comment) }}" />
            </div>


            <div class="mt-4">
                <x-ui.button variant="dark" type="submit">Create</x-ui.button>
                <x-ui.link variant="light" href="{{ route('books.show', $review->book_id) }}">Cancel</x-ui.link>
            </div>

        </form>

    </x-ui.card>

</x-layout>
