<?php

namespace App\Data;

use Illuminate\Http\UploadedFile;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\Rule;
use Spatie\LaravelData\Data;

class BookData extends Data
{
    public function __construct(
        public ?int $id,

        public string $title,
        public int $year,
        public float $rating,
        public ?string $description,
        public int $category_id,

        #[Rule(['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'])]
        public ?UploadedFile $imageFile,

        #[Nullable]
        public ?string $image = null,
    ) {}
}
