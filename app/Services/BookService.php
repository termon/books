<?php

namespace App\Services;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\LengthAwarePaginator;

class BookService
{

    public function find(int $id): Book | null
    {
        return Book::with(['category'])->find($id);
    }

    public function findAll(?string $search = null, string $sort = 'id', string $direction = 'asc', int $size = 10): LengthAwarePaginator 
    {
        $query = Book::with(['category']);      

        if ($search) {
            $query =  $query->where('title', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%")
                ->orWhere('year', 'like', "%{$search}%")
                ->orWhereHas(
                    'category',
                    fn($q) =>
                    $q->where('name', 'like', "%{$search}%")
                );
        }
        return $query->sortable($sort, $direction)->paginate($size)->withQueryString();
    }

    public function create(array $data): ?Book
    {
        // check for image, store file and add path to $data
        if ($data['image']) {
            $path = $data['image']->store('books', 'public');
            // store file path in database
            $data['image'] = $path;
        }

        // create the book
        $book = Book::create($data);
        return $book;
    }

    public function update(int|Book|null $book, array $data): ?Book
    {
        if (is_int($book)) {
            $book = Book::find($book);
        }
        if ($book === null) {
            return null;
        }

        // check if a new image has been uploaded
        //if (array_key_exists('image', $data) && $data['image']) {
        if ($data['image'] ?? null) {
            // delete old image file if found
            if ($book->image && Storage::disk('public')->exists($book->image)) {
                Storage::disk('public')->delete($book->image);
            }
            // store updated image file in public storage
            $path = $data['image']->store('books', 'public');
            $data['image'] = $path;
        }
        // update the book
        $book->update($data);

        return $book;
    }

    public function delete(int|Book|null $book): bool
    {
        // find the book if it is an integer
        if (is_int($book)) {
            $book = Book::find($book);
        }
        // return false if book is not found
        if (!$book) {
            return false;
        }

        // delete book image if found then delete the book
        if ($book->image && Storage::disk('public')->exists($book->image)) {
            Storage::disk('public')->delete($book->image);
        }
        $book->delete();
        return true;
    }

    // Return list of categories suitable for use in a select list
    public function getCategorySelectList()
    {
        return Category::all()->pluck('name', 'id');
    }
}
