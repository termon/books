<?php

namespace Tests\Unit;

use App\Models\Book;
use App\Models\Author;
use App\Services\BookService;
use App\Services\AuthorService;
use App\Services\AuthorBookService;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase; // instead of PHPUnit\Framework\TestCase; when using factories

class AuthorBookServiceIntegrationTest extends TestCase
{
    use RefreshDatabase;

    protected static AuthorService $authorService;
    protected static BookService $bookService;
    protected static AuthorBookService $authorBookService;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        self::$authorService = app(AuthorService::class);
        self::$bookService = app(BookService::class);
        self::$authorBookService = app(AuthorBookService::class);
    }

    // ============== Book Author Tests ==================

    public function test_addAuthorToBook_whenBookAndAuthorExist_ReturnsBook(): void
    {
        // arrange
        $author = self::$authorService->create(Author::factory()->make()->toArray());
        $book   = self::$bookService->create(Book::factory()->make()->toArray());

        // act
        $result = self::$authorBookService->addAuthorToBook($book, $author);

        // assert
        $this->assertEquals($result->title, $book->title);
        $this->assertEquals($result->category_id, $book->category_id);
        $this->assertEquals($result->rating, $book->rating);
        $this->assertEquals($result->description, $book->description);
    }

    public function test_addAuthorToBook_whenAuthorDoesNotExist_ReturnsNull(): void
    {
        // arrange
        $book   = self::$bookService->create(Book::factory()->make()->toArray());

        // act
        $result = self::$authorBookService->addAuthorToBook($book, null);

        // assert
        $this->assertNull($result);
    }

    public function test_addAuthorToBook_whenBookDoesNotExist_ReturnsNull(): void
    {
        // arrange
        $author = self::$authorService->create(Author::factory()->make()->toArray());

        // act
        $result = self::$authorBookService->addAuthorToBook(null, $author);

        // assert
        $this->assertNull($result);
    }

    public function test_addAuthorToBook_whenAuthorAlreadyAssociatedWithBook_ReturnsNull(): void
    {
        // arrange
        $author1 = self::$authorService->create(Author::factory()->make(["name" => "Author1"])->toArray());
        $author2 = self::$authorService->create(Author::factory()->make(["name" => "Author2"])->toArray());
        $book    = self::$bookService->create(Book::factory()->make()->toArray());

        self::$authorBookService->addAuthorToBook($book, $author1);
        self::$authorBookService->addAuthorToBook($book, $author2);

        // act - add the same author again
        $result = self::$authorBookService->addAuthorToBook($book, $author1);

        // assert
        $this->assertNull($result);
        $this->assertEquals(2, $book->authors->count());
    }

    public function test_removeAuthorFromBook_whenAuthorAssociatedWithBook_ReturnsBook(): void
    {
        // arrange
        $author1 = self::$authorService->create(Author::factory()->make(["name" => "Author1"])->toArray());
        $author2 = self::$authorService->create(Author::factory()->make(["name" => "Author2"])->toArray());
        $book   = self::$bookService->create(Book::factory()->make()->toArray());

        self::$authorBookService->addAuthorToBook($book, $author1);
        self::$authorBookService->addAuthorToBook($book, $author2);

        // act - add the same author again
        $result = self::$authorBookService->removeAuthorFromBook($book, $author1);

        // assert
        $this->assertNotNull($result);
        $this->assertEquals(1, $book->authors->count());
    }

    public function test_removeAuthorFromBook_whenAuthorNotAssociatedWithBook_ReturnsNull(): void
    {
        // arrange
        $author1 = self::$authorService->create(Author::factory()->make(["name" => "Author1"])->toArray());
        $author2 = self::$authorService->create(Author::factory()->make(["name" => "Author2"])->toArray());
        $book   = self::$bookService->create(Book::factory()->make()->toArray());

        self::$authorBookService->addAuthorToBook($book, $author1);

        // act - add the same author again
        $result = self::$authorBookService->removeAuthorFromBook($book, $author2);

        // assert
        $this->assertNull($result);
        $this->assertEquals(1, $book->authors->count());
    }
}
