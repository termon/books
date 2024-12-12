<?php

namespace App\Actions\Author;

use App\Models\Author;

class FindAuthorAction
{

    public function execute(int $id): ?Author
    {
        return Author::find($id);
    }
}
