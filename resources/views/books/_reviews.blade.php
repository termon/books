<x-ui.header class="mt-3">
    <h2>Reviews</h2>
    @can('create', App\Models\Review::class)
        <x-ui.link variant="light" href="{{ route('reviews.create', $book->id) }}" class="flex gap-1 items-center">
            <x-ui.svg size="sm" variant="plus" />
            Add
        </x-ui.link>
    @endcan
</x-ui.header>

<x-ui.card>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Reviewed</th>
                <th>Rating</th>
                <th>Comment</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($book->reviews as $review)
                <tr>
                    <td>{{ $review->name }}</td>
                    <td>{{ $review->created_at_for_humans }}</td>
                    <td>{{ $review->rating }}</td>
                    <td>{{ str($review->comment)->take(50) }}...</td>
                    <td>
                        <!-- TBC actions -->
                        <x-ui.link variant="slink" href="{{ route('reviews.show', $review->id) }}"
                            class="flex items-center">
                            <x-ui.svg variant="info" />
                            <span></span>View</span>
                        </x-ui.link>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-ui.card>
