<?php

namespace App\Actions\Book\Review;

use App\Models\Book;
use App\Models\Review;
use App\Data\ReviewData;

class CreateReviewDataAction
{
    public function execute(int|Book|null $book, ReviewData $data): ?Review
    {
        if (is_int($book)) {
            $book = Book::find($book);
        }
        // return null if book is not found
        if (!$book) {
            return null;
        }

        // business logic updating book rating
        $review = $book->reviews()->create($data->toArray());
        $book->rating = $book->reviews()->avg('rating');
        $book->save();

        return $review;
    }
}
