<?php

namespace App\Actions\Book;

use App\Data\BookData;
use App\Models\Book;
use Illuminate\Support\Facades\Storage;

class UpdateBookDataAction
{

    public function execute(int|Book|null $book, BookData $data): ?Book
    {
        if (is_int($book)) {
            $book = Book::find($book);
        }
        if ($book === null) {
            return null;
        }

        // check if a new image has been uploaded
        if ($data->imageFile) {
            // delete old image file if found
            if ($book->image && Storage::disk('public')->exists($book->image)) {
                Storage::disk('public')->delete($book->image);
            }
            // store updated image file in public storage
            $path = $data->imageFile->store('books', 'public');
            $data->image = $path;
        }
        // update the book
        $book->update($data->toArray());

        return $book;
    }
}
