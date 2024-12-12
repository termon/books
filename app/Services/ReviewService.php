<?php

namespace App\Services;

use App\Actions\Book\Review\AddReviewAction;
use App\Actions\Book\Review\DeleteReviewAction;
use App\Models\Book;
use App\Models\Review;

class ReviewService
{

    public function __construct(
        private AddReviewAction $addReviewAction = new AddReviewAction(),
        private DeleteReviewAction $deleteReviewAction = new DeleteReviewAction()
    ) {}
     
    public function create(int|Book|null $book, array $data): ?Review
    {
       return $this->addReviewAction->execute($book, $data);
    }

    public function delete(int|Review|null $review): ?Book
    {
        return $this->deleteReviewAction->execute($review);
    }
}
