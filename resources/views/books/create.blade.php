<x-layout>

    <x-ui.breadcrumb class="my-3" :crumbs="[
        'Home' => route('home'),
        'Books' => route('books.index'),
        'Create' => '',
    ]" />

    <x-ui.header>
        <h2>Create Book</h2>
    </x-ui.header>

    <x-ui.card>

        <form method="POST" action="{{ route('books.store') }}" enctype="multipart/form-data">
            @csrf

            @include('books._inputs')

            <div class="mt-4">
                <x-ui.button variant="dark" type="submit">Create</x-ui.button>
                <x-ui.link variant="light" href="{{ route('books.index') }}">Cancel</x-ui.link>
            </div>

        </form>

    </x-ui.card>

</x-layout>
