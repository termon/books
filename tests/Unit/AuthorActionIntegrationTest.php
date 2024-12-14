<?php

namespace Tests\Unit;

use App\Actions\Author\CreateAuthorAction;
use App\Actions\Author\FindAuthorAction;
use App\Models\Book;
use App\Models\Author;
use App\Models\Category;
use App\Services\AuthorService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase; // instead of PHPUnit\Framework\TestCase; when using factories

class AuthorActionIntegrationTest extends TestCase
{
    use RefreshDatabase;


    public function test_create_whenAuthorIsUnique_returnsAuthor(): void
    {
        // arrange
        $create = new CreateAuthorAction();

        // act
        $author = $create->execute(Author::factory()->make()->toArray());

        // assert
        $this->assertNotNull($author);
    }

    public function test_create_whenMultipleUniqueAuthors_returnsAuthor(): void
    {
        // arrange
        $create = new CreateAuthorAction();

        // act
        $create->execute(Author::factory()->make(["name" => "Author1"])->toArray());
        $create->execute(Author::factory()->make(["name" => "Author2"])->toArray());
        $create->execute(Author::factory()->make(["name" => "Author3"])->toArray());

        $count = Author::count();

        // assert
        $this->assertEquals(3, $count);
    }

    public function test_create_whenAuthorNotUnique_returnsNull(): void
    {
        // arrange
        $create = new CreateAuthorAction();

        $existing = $create->execute(Author::factory()->make(["name" => "Test"])->toArray());

        // act
        $author = $create->execute(Author::factory()->make(["name" => $existing->name])->toArray());

        // assert
        $this->assertNull($author);
    }

    public function test_find_whenAuthorExists_returnsAuthor(): void
    {
        // arrange
        $create = new CreateAuthorAction();
        $find = new FindAuthorAction();
        $author = $create->execute(Author::factory()->make()->toArray());

        // act
        $found = $find->execute($author->id);

        // assert
        $this->assertNotNull($found);
    }

    public function test_find_whenAuthorDoesNotExist_returnsNull(): void
    {
        // arrange
        $find = new FindAuthorAction();

        // act
        $found = $find->execute(1);

        // assert
        $this->assertNull($found);
    }
}
