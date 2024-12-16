<?php

namespace App\Actions\Book;

use App\Models\Book;
use App\Data\BookData;

class CreateBookDataAction
{
    public function execute(BookData $data): ?Book
    {

        // check for image, store file and add path to $data
        if ($data->imageFile) {
            $path = $data->imageFile->store('books', 'public');
            // store file path in database
            $data->image = $path;
        }

        return Book::create($data->except('imageFile')->toArray());
    }
}
