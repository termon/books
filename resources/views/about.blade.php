<x-layout>
    <x-ui.breadcrumb class="my-3" :crumbs="[
        'Home' => route('home'),
        'About' => '',
    ]" />

    <x-ui.card>

        <div class="flex gap-3 items-center">
            <h1>About</h1>

            <span class="badge-blue">Version 1.0</span>
        </div>

        <p class="text-xl">This is a book management application</p>

        <p>For more information <a href="/contact">contact us here</a></p>
    </x-ui.card>

</x-layout>
