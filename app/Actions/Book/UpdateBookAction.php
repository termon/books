<?php

namespace App\Actions\Book;

use App\Models\Book;
use Illuminate\Support\Facades\Storage;

class UpdateBookAction
{

    public function execute(int|Book|null $book, array $data): ?Book
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
}
