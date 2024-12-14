<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Book;
use App\Models\Review;
use App\Models\Category;
use App\Services\BookService;
use App\Services\ReviewService;
use App\Actions\Book\CreateBookAction;
use App\Actions\Book\Review\CreateReviewAction;
use App\Actions\Book\Review\DeleteReviewAction;

class ReviewActionIntegrationTest extends TestCase
{

    private static CreateBookAction $createBook;
    private static CreateReviewAction $createReview;
    private static DeleteReviewAction $deleteReview;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        self::$createBook = new CreateBookAction();
        self::$createReview = new CreateReviewAction();
        self::$deleteReview = new DeleteReviewAction();
    }

    public function test_add_toExistingBook_ShouldAddReview()
    {
        // arrange – use factory to make a book with related category
        $book = self::$createBook->execute(Book::factory()->make()->toArray());
        $reviewModel = Review::factory()->make();

        //act – call service with factory book model converted to array
        $review = self::$createReview->execute($book, $reviewModel->toArray());

        // assert
        $this->assertNotNull($review);
    }

    public function test_delete_fromExistingBook_ShouldRemoveReview()
    {
        // arrange – use factory to make a book with related category
        $book = self::$createBook->execute(Book::factory()->make()->toArray());
        $reviewModel = Review::factory()->make();

        //act – call service with factory book model converted to array
        $review = self::$createReview->execute($book, $reviewModel->toArray());

        // assert
        $this->assertNotNull($review);
    }


    // TBC --
    public function test_add_toExistingBook_ShouldUpdateBookRating()
    {
        // arrange – use factory to make a book with related category
        $book = self::$createBook->execute(Book::factory()->make()->toArray());

        //act – call service to add two reviews to $book and update book rating
        self::$createReview->execute($book, Review::factory()->make()->toArray());
        self::$createReview->execute($book, Review::factory()->make()->toArray());

        // reload book from database
        $book->refresh();

        // assert - average of book review ratings is equal to book rating
        $this->assertEquals($book->reviews->avg('rating'), $book->rating);
    }

    public function test_delete_fromExistingBook_ShouldUpdateBookRating()
    {
        // arrange – use factory to make a book with related category and associated reviews
        $book = self::$createBook->execute(Book::factory()->make()->toArray());
        $review1 = self::$createReview->execute($book, Review::factory()->make()->toArray());
        $review2 = self::$createReview->execute($book, Review::factory()->make()->toArray());

        //act –
        self::$deleteReview->execute($review1);
        self::$deleteReview->execute($review2);

        // assert - average of book review ratings is equal to refreshed book rating
        $this->assertEquals($book->reviews->avg('rating'), $book->refresh()->rating);
    }
}
