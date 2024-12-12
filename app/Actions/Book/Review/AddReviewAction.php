<?php

namespace App\Actions\Book\Review;

use App\Models\Book;
use App\Models\Review;

class AddReviewAction
{
    public function execute(int|Book|null $book, array $data): ?Review
    {
        if (is_int($book)) {
            $book = Book::find($book);
        }
        // return null if book is not found
        if (!$book) {
            return null;
        }

        // business logic updating book rating
        $review = $book->reviews()->create($data);
        $book->rating = $book->reviews()->avg('rating');
        $book->save();

        return $review;
    }
}
