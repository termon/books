<?php

namespace App\Services;

use App\Models\Book;
use App\Models\Author;
use App\Models\Category;

use App\Actions\Book\FindBookAction;
use App\Actions\Book\CreateBookAction;
use App\Actions\Book\DeleteBookAction;
use App\Actions\Book\UpdateBookAction;
use App\Actions\Book\FindAllBooksAction;

use Illuminate\Pagination\LengthAwarePaginator;

class BookService
{
    private $findBookAction;
    private $findAllBooksAction;
    private $createBookAction;
    private $updateBookAction;
    private $deleteBookAction;

    public function __construct()
    {
        $this->findBookAction = new FindBookAction();
        $this->findAllBooksAction = new FindAllBooksAction();
        $this->createBookAction = new CreateBookAction();
        $this->updateBookAction = new UpdateBookAction();
        $this->deleteBookAction = new DeleteBookAction();
    }

    public function find(int $id): Book | null
    {
        return $this->findBookAction->execute($id);
    }

    public function findAll(?string $search = null, string $sort = 'id', string $direction = 'asc', int $size = 10): LengthAwarePaginator
    {
        return $this->findAllBooksAction->execute($search, $sort, $direction, $size);
    }

    public function create(array $data): ?Book
    {
        return $this->createBookAction->execute($data);
    }

    public function update(int|Book|null $book, array $data): ?Book
    {
        return $this->updateBookAction->execute($book, $data);
    }

    public function delete(int|Book|null $book): bool
    {
        return $this->deleteBookAction->execute($book);
    }

    // Return list of categories suitable for use in a select list
    public function getCategorySelectList()
    {
        return Category::all()->pluck('name', 'id');
    }
}
