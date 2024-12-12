<?php

namespace App\Actions\Book\Author;

use App\Models\Book;
use App\Models\Author;

class AddAuthorAction
{
    /**
     * Attach author to book but only if the author is not already associated with the book
     *
     * @param int|Book|null $book - the book to accept an author
     * @param int|Author|null $author - the author to add to the book
     * @return ?Book - return null if author already associated with the book otherwise return the book
     */
    public function execute(int|Book|null $book, int|Author|null $author): ?Book
    {
        // check if book and author need loaded
        if (is_int($book)) {
            $book = Book::with(['category', 'authors'])->find($book);
        }
        if (is_int($author)) {
            $author = Author::find($author);
        }

        // if book or author is not found return null
        if ($book === null || $author === null) {
            return null;
        }

        // check if author is already associated with the book and if so return null
        $exists = $book->authors()->where('author_id', $author->id)->exists();
        if ($exists) {
            return null;
        }

        // attach author to book and return the book
        $book->authors()->attach($author);

        return $book;
    }
}
