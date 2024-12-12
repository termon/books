@can('delete', $book)
    <!-- Trigger button -->
    <x-ui.button variant="ored" x-data @click="$dispatch('open-modal')">Delete</x-ui.button>
@endcan

<x-ui.modal>
    <x-slot:title>
        Confirm
    </x-slot:title>

    <p>Are you sure you want to delete {{ $book->title }} ?</p>

    <x-slot:footer>
        <form method="POST" action="{{ route('books.destroy', $book->id) }}">
            @csrf
            @method('DELETE')
            <x-ui.button type="submit" variant="red">Delete</x-ui.button>
            <x-ui.link variant="light" x-data @click="$dispatch('close-modal')">Cancel</x-ui.link>
        </form>

    </x-slot:footer>
</x-ui.modal>
