<?php

namespace App\Actions\Book;

use App\Models\Book;

class CreateBookAction {
    public function execute(array $data): ?Book {
        // check for image, store file and add path to $data
        if ($data['image']) {
            $path = $data['image']->store('books', 'public');
            // store file path in database
            $data['image'] = $path;
        }
        return Book::create($data);
    }
}
