<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class BookData extends Data
{
    public function __construct(
      public string $title,
      public int $year,
      public float $rating,
      public string $description,
      public string $image
    ) {}
}
