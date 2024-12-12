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

    public function test_create_whenAuthorUnique_returnsAuthor(): void
    {
        // arrange


        // act
        $author = self::$service->create(Author::factory()->make()->toArray());

        // assert
        $this->assertNotNull($author);
    }

    public function test_create_whenMultipleUniqueAuthors_createsAuthors(): void
    {
        // arrange

        // act
        $author1 = self::$service->create(Author::factory()->make(["name" => "Author1"])->toArray());
        $author2 = self::$service->create(Author::factory()->make(["name" => "Author2"])->toArray());
        $author3 = self::$service->create(Author::factory()->make(["name" => "Author3"])->toArray());

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
}
