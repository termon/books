<?php

namespace App\Actions\Book;

use App\Models\Book;

class FindBookAction
{

    public function execute(int $id): ?Book
    {
        return Book::with(['category'])->find($id);
    }
}
