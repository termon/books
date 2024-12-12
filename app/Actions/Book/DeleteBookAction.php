<?php

namespace App\Actions\Book;

use App\Models\Book;
use Illuminate\Support\Facades\Storage;

class DeleteBookAction
{
    public function execute(int|Book|null $book): bool
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
}
