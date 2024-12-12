<?php

namespace Tests\Unit;

use App\Models\Book;
use App\Models\Author;
use App\Models\Category;
use App\Services\AuthorService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase; // instead of PHPUnit\Framework\TestCase; when using factories

class AuthorServiceIntegrationTest extends TestCase
{
    use RefreshDatabase;

    protected static AuthorService $service;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        self::$service = app(AuthorService::class);
    }

    public function test_create_whenAuthorIsUnique_returnsAuthor(): void
    {
        // arrange

        // act
        $author = self::$service->create(Author::factory()->make()->toArray());

        // assert
        $this->assertNotNull($author);
    }

    public function test_create_whenMultipleUniqueAuthors_returnsAuthor(): void
    {
        // arrange

        // act
        self::$service->create(Author::factory()->make(["name" => "Author1"])->toArray());
        self::$service->create(Author::factory()->make(["name" => "Author2"])->toArray());
        self::$service->create(Author::factory()->make(["name" => "Author3"])->toArray());

        $count = Author::count();

        // assert
        $this->assertEquals(3, $count);
    }

    public function test_create_whenAuthorNotUnique_returnsNull(): void
    {
        // arrange
        $existing = self::$service->create(Author::factory()->make(["name" => "Test"])->toArray());

        // act
        $author = self::$service->create(Author::factory()->make(["name" => $existing->name])->toArray());

        // assert
        $this->assertNull($author);
    }

    public function test_find_whenAuthorExists_returnsAuthor(): void
    {
        // arrange
        $author = self::$service->create(Author::factory()->make()->toArray());

        // act
        $found = self::$service->find($author->id);

        // assert
        $this->assertNotNull($found);
    }

    public function test_find_whenAuthorDoesNotExist_returnsNull(): void
    {
        // arrange

        // act
        $found = self::$service->find(1);

        // assert
        $this->assertNull($found);
    }
}
