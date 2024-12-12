<?php

namespace App\Actions\Author;

use App\Models\Author;

class CreateAuthorAction {

    public function execute(array $data): ?Author 
    {
        // check author with same name does not exist
        $found = Author::where('name', $data['name'])->first();
        if($found) {
           return null;
        }

        return Author::create($data);
    }
}
