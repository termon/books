<?php

namespace Tests\Unit;

use App\Models\Book;
use App\Models\Author;
use App\Actions\Book\CreateBookAction;
use App\Actions\Author\CreateAuthorAction;
use App\Actions\Book\Author\AddAuthorToBookAction;


use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Actions\Book\Author\RemoveAuthorFromBookAction;
use Tests\TestCase; // instead of PHPUnit\Framework\TestCase; when using factories

class AuthorBookActionIntegrationTest extends TestCase
{
    use RefreshDatabase;

    private static CreateAuthorAction $createAuthor;
    private static CreateBookAction $createBook;
    private static AddAuthorToBookAction $addAuthorToBook;
    private static RemoveAuthorFromBookAction $removeAuthorFromBook;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        self::$createAuthor = new CreateAuthorAction();
        self::$createBook = new CreateBookAction();
        self::$addAuthorToBook = new AddAuthorToBookAction();
        self::$removeAuthorFromBook = new RemoveAuthorFromBookAction();
    }

    // ============== Book Author Tests ==================

    public function test_addAuthorToBook_whenBookAndAuthorExist_ReturnsBook(): void
    {
        // arrange
        $author = self::$createAuthor->execute(Author::factory()->make()->toArray());
        $book   = self::$createBook->execute(Book::factory()->make()->toArray());

        // act
        $result = self::$addAuthorToBook->execute($book, $author);

        // assert
        $this->assertEquals($result->title, $book->title);
        $this->assertEquals($result->category_id, $book->category_id);
        $this->assertEquals($result->rating, $book->rating);
        $this->assertEquals($result->description, $book->description);
    }

    public function test_addAuthorToBook_whenAuthorDoesNotExist_ReturnsNull(): void
    {
        // arrange
        $book   = self::$createBook->execute(Book::factory()->make()->toArray());

        // act
        $result = self::$addAuthorToBook->execute($book, null);

        // assert
        $this->assertNull($result);
    }

    public function test_addAuthorToBook_whenBookDoesNotExist_ReturnsNull(): void
    {
        // arrange
        $author = self::$createAuthor->execute(Author::factory()->make()->toArray());

        // act
        $result = self::$addAuthorToBook->execute(null, $author);

        // assert
        $this->assertNull($result);
    }

    public function test_addAuthorToBook_whenAuthorAlreadyAssociatedWithBook_ReturnsNull(): void
    {
        // arrange
        $author1 = self::$createAuthor->execute(Author::factory()->make(["name" => "Author1"])->toArray());
        $author2 = self::$createAuthor->execute(Author::factory()->make(["name" => "Author2"])->toArray());
        $book    = self::$createBook->execute(Book::factory()->make()->toArray());

        self::$addAuthorToBook->execute($book, $author1);
        self::$addAuthorToBook->execute($book, $author2);

        // act - add the same author again
        $result = self::$addAuthorToBook->execute($book, $author1);

        // assert
        $this->assertNull($result);
        $this->assertEquals(2, $book->authors->count());
    }

    public function test_removeAuthorFromBook_whenAuthorAssociatedWithBook_ReturnsBook(): void
    {
        // arrange
        $author1 = self::$createAuthor->execute(Author::factory()->make(["name" => "Author1"])->toArray());
        $author2 = self::$createAuthor->execute(Author::factory()->make(["name" => "Author2"])->toArray());
        $book   = self::$createBook->execute(Book::factory()->make()->toArray());

        self::$addAuthorToBook->execute($book, $author1);
        self::$addAuthorToBook->execute($book, $author2);

        // act - add the same author again
        $result = self::$removeAuthorFromBook->execute($book, $author1);

        // assert
        $this->assertNotNull($result);
        $this->assertEquals(1, $book->authors->count());
    }

    public function test_removeAuthorFromBook_whenAuthorNotAssociatedWithBook_ReturnsNull(): void
    {
        // arrange
        $author1 = self::$createAuthor->execute(Author::factory()->make(["name" => "Author1"])->toArray());
        $author2 = self::$createAuthor->execute(Author::factory()->make(["name" => "Author2"])->toArray());
        $book   = self::$createBook->execute(Book::factory()->make()->toArray());

        self::$addAuthorToBook->execute($book, $author1);

        // act - add the same author again
        $result = self::$removeAuthorFromBook->execute($book, $author2);

        // assert
        $this->assertNull($result);
        $this->assertEquals(1, $book->authors->count());
    }
}
