<div class="mt-2">
    <x-ui.form.input label="Title" name="title" type="text" value="{{ old('title', $book->title) }}" />
</div>

<div class="mt-2">
    <x-ui.form.select label="Category" name="category_id" :options="$categories"
        value="{{ old('category_id', $book->category_id) }}" />
</div>

<div class="flex gap-2 mt-2">
    <div class="w-1/2">
        <x-ui.form.input label="Year" name="year" type="number" value="{{ old('year', $book->year) }}" />
    </div>
    <div class="w-1/2">
        <x-ui.form.input label="Rating" name="rating" type="number" value="{{ old('rating', $book->rating) }}" />
    </div>
</div>

<div class="mt-2">
    <x-ui.form.textarea label="Description" name="description" rows="6">
        {{ old('description', $book->description) }}
    </x-ui.form.textarea>
</div>

<div class="flex gap-2 items-start mt-2">
    <div class="w-full">
        <x-ui.form.input label="Cover" name="image" type="file" value="{{ old('image', $book->image) }}" />
    </div>
    <!-- display existing image if available -->
    @if ($book->image)
        <div class="w-1/3">
            {{-- <img src="{{ $book->image }}" alt="{{ $book->title }}"> --}}
            <img src="{{ Storage::url($book->image) }}" alt="{{ $book->title }}">
        </div>
    @endif
</div>
