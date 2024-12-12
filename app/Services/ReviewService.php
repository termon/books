<?php

namespace App\Services;

use App\Models\Book;
use App\Models\Review;

class ReviewService
{
    public function create(int|Book|null $book, array $data): ?Review
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

    public function delete(int|Review|null $review): ?Book
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
