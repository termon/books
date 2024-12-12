<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Practical 12</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <style type="text/tailwindcss">
        @layer components {

            h1 {
                @apply text-3xl font-semibold py-2;
            }

            h2 {
                @apply text-2xl font-semibold py-3;
            }

            h3 {
                @apply text-xl font-semibold py-2;
            }

            h4 {
                @apply text-lg font-semibold py-2;
            }

            .table {
                @apply w-full text-sm text-left text-gray-500;
            }

            /* child selector > */
            .table>thead {
                @apply text-xs text-gray-700 uppercase bg-gray-50;
            }

            .table>thead>tr>th {
                @apply px-6 py-3;
            }

            .table>tbody>tr {
                @apply bg-white border-b;
            }

            .table>tbody>tr>td {
                @apply px-6 py-3;
            }

            .display {
                @apply flex border-b border-slate-200 sm:py-2 md:py-3 rounded-md;
            }

            .display>dt {
                @apply font-bold text-black dark:text-white mr-5;
            }

            .display>dd {
                @apply text-slate-500 dark:text-slate-100 mr-5;
            }
        }
    </style>
</head>

<body>
    <header>
        <!-- page navbar -->
        <x-ui.nav class="bg-slate-50">
            <x-ui.nav.title class="flex items-center">
                <x-ui.svg book size="lg" />
                <span>COM621</span>
            </x-ui.nav.title>

            <x-slot:center>
                <x-ui.nav.link active="home" href="{{ route('home') }}">Home</x-ui.nav.link>

                @auth
                    <x-ui.nav.link active="books.index" href="{{ route('books.index') }}">Books</x-ui.nav.link>
                @endauth

                <x-ui.nav.link class="px-2" active="about" href="{{ route('about') }}">About</x-ui.nav.link>
                <x-ui.nav.link class="px-2" active="contact" href="{{ route('contact') }}">Contact</x-ui.nav.link>

                {{-- <x-ui.nav.drop label="About">
                    <x-ui.nav.drop.link class="px-2" active="about" :href="route('about')">About</x-ui.nav.drop.link>
                    <x-ui.nav.drop.link class="px-2" active="contact" :href="route('contact')">Contact</x-ui.nav.drop.link>
                </x-ui.nav.drop> --}}

            </x-slot:center>

            <x-slot:right>
                {{-- <x-ui.nav.drop position="left">
                    <x-slot:title>
                        @guest
                            <div class="flex items-center">
                                <x-ui.nav.link variant="nav" href="{{ route('login') }}">Login</x-ui.nav.link>
                                <x-ui.nav.link variant="nav" href="{{ route('register') }}">Register</x-ui.nav.link>
                            </div>
                        @endguest
                        @auth
                            <span>{{ auth()->user()->name }}</span>
                            <span class="text-gray-400 text-xs">
                                ({{ auth()->user()->role }})
                            </span>
                        @endauth
                    </x-slot>

                    @auth
                        <form method="post" action="{{ route('logout') }}" class="flex gap-2 p-0 m-0">
                            @csrf
                            <x-ui.nav.button type="submit">
                                Logout
                            </x-ui.nav.button>
                        </form>
                    @endauth
                </x-ui.nav.drop> --}}

                @guest
                    <div class="flex items-center">
                        <x-ui.nav.link variant="nav" href="{{ route('login') }}">Login</x-ui.nav.link>
                        <x-ui.nav.link variant="nav" href="{{ route('register') }}">Register</x-ui.nav.link>
                    </div>
                @endguest
                @auth
                    <form method="post" action="{{ route('logout') }}" class="flex gap-2 p-0 m-0">
                        @csrf
                        <x-ui.nav.button type="submit">
                            Logout
                        </x-ui.nav.button>
                    </form>
                    <span class="text-gray-400 text-xs">
                        {{ auth()->user()->name }}({{ auth()->user()->role }})
                    </span>
                @endauth
            </x-slot:right>
        </x-ui.nav>
    </header>

    <!-- page content area -->
    @include('_alert')

    <main class="container mx-auto my-5">
        {{ $slot }}
    </main>

    <!-- page footer -->
    <footer class="py-3 px-6 border-t flex gap-2 justify-center items-center">
        <p>&copy; {{ date('Y') }} COM621 </p>

        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="100" height="100" viewBox="0 0 24 24"
            class="w-6 h-6">
            <path
                d="M19,3H5C3.895,3,3,3.895,3,5v14c0,1.105,0.895,2,2,2h14c1.105, 0,2-0.895,2-2V5C21,3.895,20.105,3,19,3z M9,17H6.477v-7H9 V17z M7.694,8.717c-0.771,0-1.286-0.514-1.286-1.2s0.514-1.2,1.371-1.2c0.771,0,1.286,0.514,1.286,1.2S8.551,8.717,7.694,8.717z M18,17h-2.442v-3.826c0-1.058-0.651-1.302-0.895-1.302s-1.058, 0.163-1.058, 1.302c0,0.163,0,3.826,0, 3.826h-2.523v-7h2.523v0.977 C13.93,10.407,14.581,10, 15.802,10C17.023,10,18,10.977,18,13.174V17z">
            </path>
        </svg>

        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="100" height="100" viewBox="0 0 24 24"
            class="w-6 h-6">
            <path
                d="M10.053,7.988l5.631,8.024h-1.497L8.566,7.988H10.053z M21,6v12 c0,1.657-1.343,3-3,3H6c-1.657,0-3-1.343-3-3V6c0-1.657, 1.343-3,3-3h12C19.657,3,21,4.343,21,6z M17.538,17l-4.186-5.99L16.774, 7 h-1.311l-2.704,3.16L10.552,7H6.702l3.941,5.633L6.906, 17h1.333l3.001-3.516L13.698,17H17.538z">
            </path>
        </svg>
    </footer>

</body>

</html>
