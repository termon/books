<x-layout>

    <x-ui.header>
        <h2>Register</h2>
    </x-ui.header>

    <x-ui.card>
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- name -->
            <div class="mt-2">
                <x-ui.form.input label="Name" name="name" type="text" />
            </div>

            <!-- email -->
            <div class="mt-2">
                <x-ui.form.input label="Email" name="email" type="email" />
            </div>

            <!-- passwords -->
            <div class="flex gap-2 mt-2">
                <div class="w-full">
                    <x-ui.form.input label="Password" name="password" type="password" />
                </div>
                <div class="w-full">
                    <x-ui.form.input label="Confirm Password" name="password_confirmation" type="password" />
                </div>
            </div>

            <!-- submit -->
            <div class="mt-4">
                <x-ui.button variant="dark" type="submit">Login</x-ui.button>
                <x-ui.link variant="light" href="{{ route('home') }}">Cancel</x-ui.link>
            </div>

        </form>
    </x-ui.card>

</x-layout>
