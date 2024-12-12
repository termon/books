<?php

namespace Tests\Unit;

use App\Models\Book;
use App\Models\Author;
use App\Models\Category;
use App\Services\BookService;
use App\Services\AuthorService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase; // instead of PHPUnit\Framework\TestCase; when using factories

class BookServiceIntegrationTest extends TestCase
{
    use RefreshDatabase;

    protected static BookService $service;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        self::$service = app(Bookservice::class);
    }

    private function makeBookModel(?Category $c = null): Book
    {
        $category = $c ?? Category::factory()->make();
        return Book::factory()->make(["category" => $category]);
    }

    public function test_findAll_whenNoBooks_returnsNone(): void
    {
        // arrange

        // act
        $books = self::$service->findAll();

        // assert
        $this->assertEquals(0, $books->count());
    }

    public function test_create_returnsBook(): void
    {
        // arrange – use factory to make a book with related category
        $model = $this->makeBookModel();

        //act – call service with factory book model converted to array
        $book = self::$service->create($model->toArray());

        // assert - that book attributes match factory model attributes
        $this->assertEquals($book->title, $model->title);
        $this->assertEquals($book->category_id, $model->category_id);
        $this->assertEquals($book->rating, $model->rating);
        $this->assertEquals($book->description, $model->description);
        $this->assertEquals($book->image, $model->image);
    }

    public function test_create_withImage_storesImage(): void
    {
        // arrange – use factory to make a book with related category
        $model = $this->makeBookModel();

        //act – call service with factory book model converted to array
        $book = self::$service->create($model->toArray());

        // assert - that book attributes match factory model attributes
        $this->assertEquals($book->title, $model->title);
        $this->assertEquals($book->category_id, $model->category_id);
        $this->assertEquals($book->rating, $model->rating);
        $this->assertEquals($book->description, $model->description);
        $this->assertEquals($book->image, $model->image);
    }

    public function test_find_whenBookExists_returnsBook(): void
    {
        // arrange – use service to create a book using a factory model
        $model = self::$service->create($this->makeBookModel()->toArray());

        //act – use service to find book
        $book = self::$service->find($model->id);

        // assert - that book attributes match factory model attributes
        $this->assertEquals($book->title, $model->title);
        $this->assertEquals($book->category_id, $model->category_id);
        $this->assertEquals($book->rating, $model->rating);
        $this->assertEquals($book->description, $model->description);
        $this->assertEquals($book->image, $model->image);
    }
    //
    public function test_findAll_whenOneBook_ReturnsOne(): void
    {
        // arrange
        self::$service->create($this->makeBookModel()->toArray());

        // act
        $books = self::$service->findAll();

        // assert
        $this->assertEquals(1, $books->count());
    }

    public function test_delete_WhenBookDoesntExist_ReturnsFalse(): void
    {
        // arrange

        // act
        $result = self::$service->delete(1);

        // assert
        $this->assertEquals(false, $result);
    }


    public function test_delete_whenBookExists_ReturnsTrue(): void
    {
        // arrange
        $book = self::$service->create($this->makeBookModel()->toArray());

        // act
        $result = self::$service->delete($book);

        // assert
        $this->assertEquals(true, $result);
    }


    public function test_update_WhenBookExists_ReturnsUpdatedBook(): void
    {
        // arrange
        $book = self::$service->create($this->makeBookModel()->toArray());

        // act
        $changes = Book::factory()->make();
        $updated = self::$service->update($book, $changes->toArray());

        // assert
        $this->assertEquals($updated->title, $changes->title);
        $this->assertEquals($updated->category_id, $changes->category_id);
        $this->assertEquals($updated->rating, $changes->rating);
        $this->assertEquals($updated->description, $changes->description);
    }
}
