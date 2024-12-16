<?php

namespace App\Data;

use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\Rule;
use Spatie\LaravelData\Data;

class ReviewData extends Data
{
    public function __construct(

        public ?int $id,

        public string $name,

        #[Rule(['numeric', 'min:0', 'max:5'])]
        public float $rating,

        #[Rule(['min:0', 'max:500'])]
        public string $comment,

        public ?int $book_id

    ) {}
}
