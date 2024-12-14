<?php

namespace Tests\Unit;

use App\Models\Book;
use App\Models\Author;
use App\Models\Category;
use App\Services\BookService;
use App\Services\AuthorService;
use App\Actions\Book\FindBookAction;
use App\Actions\Book\CreateBookAction;
use App\Actions\Book\DeleteBookAction;
use App\Actions\Book\UpdateBookAction;
use App\Actions\Book\FindAllBooksAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase; // instead of PHPUnit\Framework\TestCase; when using factories

class BookActionIntegrationTest extends TestCase
{
    use RefreshDatabase;

    private static CreateBookAction $createBook;
    private static FindBookAction $findBook;
    private static DeleteBookAction $deleteBook;
    private static UpdateBookAction $updateBook;
    private static FindAllBooksAction $findAllBooks;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        self::$createBook = new CreateBookAction();
        self::$findBook = new FindBookAction();
        self::$deleteBook = new DeleteBookAction();
        self::$updateBook = new UpdateBookAction();
        self::$findAllBooks = new FindAllBooksAction();
    }

    public function test_findAll_whenNoBooks_returnsNone(): void
    {
        // arrange

        // act
        $books = self::$findAllBooks->execute();

        // assert
        $this->assertEquals(0, $books->count());
    }

    public function test_create_returnsBook(): void
    {
        // arrange – use factory to make a book with related category
        $model = Book::factory()->make();

        //act – call service with factory book model converted to array
        $book = self::$createBook->execute($model->toArray());

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
        $model = Book::factory()->make();

        //act – call service with factory book model converted to array
        $book = self::$createBook->execute($model->toArray());

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
        $model = self::$createBook->execute(Book::factory()->make()->toArray());

        //act – use service to find book
        $book = self::$findBook->execute($model->id);

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
        self::$createBook->execute(Book::factory()->make()->toArray());

        // act
        $books = self::$findAllBooks->execute();

        // assert
        $this->assertEquals(1, $books->count());
    }

    public function test_delete_WhenBookDoesntExist_ReturnsFalse(): void
    {
        // arrange
        $deleteAction = new DeleteBookAction();

        // act
        $result = $deleteAction->execute(1);

        // assert
        $this->assertEquals(false, $result);
    }


    public function test_delete_whenBookExists_ReturnsTrue(): void
    {
        // arrange
        $book = self::$createBook->execute(Book::factory()->make()->toArray());

        // act
        $result = self::$deleteBook->execute($book);

        // assert
        $this->assertEquals(true, $result);
    }


    public function test_update_WhenBookExists_ReturnsUpdatedBook(): void
    {
        // arrange
        $book = self::$createBook->execute(Book::factory()->make()->toArray());

        // act
        $changes = Book::factory()->make();
        $updated = self::$updateBook->execute($book, $changes->toArray());

        // assert
        $this->assertEquals($updated->title, $changes->title);
        $this->assertEquals($updated->category_id, $changes->category_id);
        $this->assertEquals($updated->rating, $changes->rating);
        $this->assertEquals($updated->description, $changes->description);
    }
}
