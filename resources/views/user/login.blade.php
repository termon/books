<x-layout>
    <x-ui.header>
        <h2>Login</h2>
    </x-ui.header>

    <x-ui.card>
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mt-2">
                <x-ui.form.input label="Email" name="email" type="email" />
            </div>

            <div class="mt-2">
                <x-ui.form.input label="Password" name="password" type="password" />
            </div>

            <div class="mt-4">
                <x-ui.button variant="dark" type="submit">Login</x-ui.button>
                <x-ui.link variant="light" href="{{ route('home') }}">Cancel</x-ui.link>
            </div>

        </form>
    </x-ui.card>
</x-layout>
