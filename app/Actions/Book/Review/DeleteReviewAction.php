<?php

namespace App\Actions\Book\Review;

use App\Models\Book;
use App\Models\Review;

class DeleteReviewAction
{

    public function execute(int|Review|null $review): ?Book
    {
        if (is_int($review)) {
            $review = Review::with('book')->find($review);
        }
        if (!$review || !$review->book) {
            return null;
        }

        $book = $review->book;
        $review->delete();

        $book->rating = $book->reviews()->avg('rating');
        $book->save();

        return $book;
    }
}
