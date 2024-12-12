<x-layout>

    <x-ui.breadcrumb class="my-3" :crumbs="[
        'Home' => '',
    ]" />
    <section class="bg-white">
        <div class="flex flex-col items-center justify-center py-8 px-4 mx-auto max-w-screen-xl lg:py-16">
            <h1
                class="flex gap-2 items-baseline mb-4 text-4xl font-extrabold tracking-tight leading-none text-gray-900 md:text-5xl lg:text-6xl ">
                <span>The Book Manager</span>
                <x-ui.svg book size="xl" />
            </h1>

            <p class="mb-8 text-lg font-normal text-gray-500 lg:text-xl sm:px-16 lg:px-48 ">Helping you manage your book
                library</p>

        </div>

    </section>

</x-layout>
