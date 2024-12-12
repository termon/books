<?php

namespace Tests\Feature;

use App\Enums\Role;
use Tests\TestCase;
use App\Models\Book;
use App\Models\User;
use App\Models\Review;
use App\Services\BookService;
use App\Services\ReviewService;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReviewControllerTest extends TestCase
{
    use RefreshDatabase;

    protected static BookService $service;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        self::$service = app(Bookservice::class);
    }

    public function test_create_whenUnauthenticated_returns403Response(): void
    {
        // arrange
        $book = self::$service->create(Book::factory()->make()->toArray());
        $data = Review::factory()->make(['book' => $book]);

        // act
        $response = $this->json('POST', "/reviews/{$book->id}", $data->toArray());

        // assert
        $response->assertStatus(403);
    }


    public function test_create_whenUnauthorised_returns403Response(): void
    {
        // arrange
        $this->actingAs(User::factory()->create(['role' => Role::AUTHOR]));
        $book = self::$service->create(Book::factory()->make()->toArray());
        $data = Review::factory()->make(['book' => $book]);

        // act
        $response = $this->json('POST', "/reviews/{$book->id}", $data->toArray());

        // assert
        $response->assertStatus(403);
    }

    public function test_create_whenAuthorised_returns302Response(): void
    {
        // arrange
        $this->actingAs(User::factory()->create(['role' => Role::GUEST]));
        $book = self::$service->create(Book::factory()->make()->toArray());
        $data = Review::factory()->make(['book' => $book]);

        // act
        $response = $this->json('POST', "/reviews/{$book->id}", $data->toArray());

        // assert
        $response->assertStatus(302);
    }
}
