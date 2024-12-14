<?php

namespace Tests\Feature;

use App\Actions\Book\CreateBookAction;
use App\Enums\Role;
use Tests\TestCase;
use App\Models\Book;
use App\Models\User;
use App\Models\Review;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReviewControllerTest extends TestCase
{
    use RefreshDatabase;

    private static CreateBookAction $createBook;


    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        self::$createBook = new CreateBookAction();
    }

    public function test_create_whenUnauthenticated_returns403Response(): void
    {
        // arrange
        $book = self::$createBook->execute(Book::factory()->make()->toArray());
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
        $book = self::$createBook->execute(Book::factory()->make()->toArray());
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
        $book = self::$createBook->execute(Book::factory()->make()->toArray());
        $data = Review::factory()->make(['book' => $book]);

        // act
        $response = $this->json('POST', "/reviews/{$book->id}", $data->toArray());

        // assert
        $response->assertStatus(302);
    }
}
