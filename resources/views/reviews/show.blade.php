<x-layout>

    <x-ui.breadcrumb class="my-3" :crumbs="[
        'Home' => route('home'),
        'Books' => route('books.index'),
        $review->book_id => route('books.show', $review->book->id),
        'Review' => '',
    ]" />

    <x-ui.header>
        <h2>Review</h2>
        <x-ui.link variant="light" href="{{ route('books.show', $review->book_id) }}">Book</x-ui.link>
    </x-ui.header>

    <x-ui.card>

        <div class="flex items-center gap-2">
            <h3>{{ $review->book->title }}</h3>
            <span class="badge badge-blue"> {{ $review->book->category->name }}</span>
        </div>

        <dl class="display">
            <dt>Name</dt>
            <dd>{{ $review->name }}</dd>
        </dl>

        <dl class="display">
            <dt>Rating</dt>
            <dd>{{ $review->rating }}</dd>
        </dl>

        <dl class="display">
            <dt>Reviewed</dt>
            <dd>{{ $review->created_at_for_humans }}</dd>
        </dl>

        <dl class="display">
            <dt>Comment</dt>
            <dd>{{ $review->comment }}</dd>
        </dl>

        <div class="flex justify-end gap-2 mt-2">
            @can('delete', $review)
                <!-- Trigger button -->
                <x-ui.button variant="ored" x-data @click="$dispatch('open-modal')">Delete</x-ui.button>
            @endcan
        </div>

        <x-ui.modal>
            <x-slot:title>
                Delete Review
            </x-slot:title>

            <p>Are you sure you want to delete this review ?</p>

            <x-slot:footer>
                <form method="POST" action="{{ route('reviews.destroy', $review->id) }}">
                    @csrf
                    @method('DELETE')
                    <x-ui.button type="submit" variant="red">Delete</x-ui.button>
                    <x-ui.link variant="light" x-data @click="$dispatch('close-modal')">Cancel</x-ui.link>
                </form>
            </x-slot:footer>
        </x-ui.modal>

    </x-ui.card>
</x-layout>
