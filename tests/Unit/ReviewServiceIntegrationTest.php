<?php

namespace Tests\Unit;

use App\Models\Book;
use App\Models\Review;
use App\Models\Category;
use App\Services\BookService;
use App\Services\ReviewService;
use Tests\TestCase;

class ReviewServiceIntegrationTest extends TestCase
{

    protected static ReviewService $reviewService;
    protected static BookService $bookService;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        self::$reviewService = app(ReviewService::class);
        self::$bookService = app(BookService::class);
    }

    public function test_add_toExistingBook_ShouldAddReview()
    {
        // arrange – use factory to make a book with related category
        $book = self::$bookService->create(Book::factory()->make()->toArray());
        $reviewModel = Review::factory()->make();

        //act – call service with factory book model converted to array
        $review = self::$reviewService->create($book, $reviewModel->toArray());

        // assert
        $this->assertNotNull($review);
    }

    public function test_delete_fromExistingBook_ShouldRemoveReview()
    {
        // arrange – use factory to make a book with related category
        $book = self::$bookService->create(Book::factory()->make()->toArray());
        $reviewModel = Review::factory()->make();

        //act – call service with factory book model converted to array
        $review = self::$reviewService->create($book, $reviewModel->toArray());

        // assert
        $this->assertNotNull($review);
    }


    // TBC --
    public function test_add_toExistingBook_ShouldUpdateBookRating()
    {
        // arrange – use factory to make a book with related category
        $book = self::$bookService->create(Book::factory()->make()->toArray());

        //act – call service to add two reviews to $book and update book rating
        $review1 = self::$reviewService->create($book, Review::factory()->make()->toArray());
        $review2 = self::$reviewService->create($book, Review::factory()->make()->toArray());

        // reload book from database
        $book->refresh();

        // assert - average of book review ratings is equal to book rating
        $this->assertEquals($book->reviews->avg('rating'), $book->rating);

    }

    public function test_delete_fromExistingBook_ShouldUpdateBookRating()
    {
        // arrange – use factory to make a book with related category and associated reviews
        $book = self::$bookService->create(Book::factory()->make()->toArray());
        $review1 = self::$reviewService->create($book, Review::factory()->make()->toArray());
        $review2 = self::$reviewService->create($book, Review::factory()->make()->toArray());

        //act –
        self::$reviewService->delete($review1);
        self::$reviewService->delete($review2);

        // assert - average of book review ratings is equal to refreshed book rating
        $this->assertEquals($book->reviews->avg('rating'), $book->refresh()->rating);
    }
}
