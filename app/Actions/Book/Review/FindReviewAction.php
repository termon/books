<?php

namespace App\Actions\Book\Review;

use App\Models\Review;

class FindReviewAction
{
    public function execute(int $id): ?Review
    {
        return Review::with(['book'])->find($id);
    }
}
