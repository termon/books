<?php

namespace App\Actions\Author;

use App\Models\Author;

class DeleteAuthorAction
{
    public function execute(int|Author|null $author): bool
    {
        // find the auhor if it is an integer
        if (is_int($author)) {
            $author = Author::find($author);
        }
        // return false if author is not found
        if (!$author) {
            return false;
        }
        // delete auhor       
        $author->delete();
        return true;
    }
}
