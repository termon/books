<?php

namespace App\Actions\Book\Author;

use App\Models\Book;
use App\Models\Author;

class RemoveAuthorFromBookAction
{
    public function execute(int|Book|null $book, int|Author|null $author): ?Book
    {
        // check if book and author need loaded
        if (is_int($book)) {
            $book = Book::find($book);
        }
        if (is_int($author)) {
            $author = Author::find($author);
        }
        // if book or author is not found return null
        if ($book === null || $author === null) {
            return null;
        }

        // check that the author is already associated with the book
        $exists = $book->authors()->where('author_id', $author->id)->exists();
        if (!$exists) {
            return null;
        }

        // detach author from book
        $book->authors()->detach($author);
        return $book;
    }
}
