<?php

namespace Tests\Feature;

use App\Enums\Role;
use Tests\TestCase;
use App\Models\Book;
use App\Models\User;

class BookControllerTest extends TestCase
{
    // INDEX

    public function test_index_whenUnauthenticated_returns302Response(): void
    {
        //act
        $response = $this->get('/books');

        // assert
        $response->assertStatus(302);
    }

    public function test_index_whenAuthenticated_returns200Response(): void
    {
        // arrange
        $this->actingAs(User::factory()->create());

        // act
        $response = $this->get('/books');

        // assert
        $response->assertStatus(200);
    }


    // TBC -- feature to only allow AUTHORS to see create link on index page
    public function test_index_whenNotAuthorised_createLinkNotVisible(): void
    {
        // arrange
        $this->actingAs(User::factory()->create(['role' => Role::GUEST]));

        // act
        $response = $this->get('/books');

        // assert       
        $response->assertDontSeeText("Create");
       
    }

    // CREATE

    // TBC ---
    public function test_create_whenNotAuthorised_returns302Response(): void
    {
        // arrange
        $this->actingAs(User::factory()->create(['role' => Role::GUEST]));

        // act
        $response = $this->get('/books/create');


        // assert
        $response->assertStatus(302);

    }

    public function test_create_whenAuthorised_returns200Response(): void
    {
        // arrange
        $this->actingAs(User::factory()->create(['role' => Role::AUTHOR]));


        // act
        $response = $this->get('/books/create');

        // assert
        $response->assertStatus(200);

    }

    // STORE
    public function test_store_whenAuthorised_returns200Response(): void
    {
        // arrange
        $this->actingAs(User::factory()->create(['role' => Role::AUTHOR]));
        $data = Book::factory()->make();

        // act
        $response = $this->json('POST', '/books', $data->toArray());

        // assert
        $response->assertStatus(302);
    }

    // OPTIONAL - add tests for update and delete features

    // UPDATE --



    // DELETE --


}
