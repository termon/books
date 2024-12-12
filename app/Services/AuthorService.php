<?php

namespace App\Services;

use App\Actions\Author\CreateAuthorAction;
use App\Actions\Author\DeleteAuthorAction;
use App\Models\Author;

class AuthorService
{

    public function __construct(
        private CreateAuthorAction $addAuthorAction = new CreateAuthorAction(),
        private DeleteAuthorAction $deleteAuthorAction = new DeleteAuthorAction()
    ) {}
     
    public function create(array $data): ?Author
    {
       return $this->addAuthorAction->execute($data);
    }

    public function delete(int|Author|null $author): bool
    {
        return $this->deleteAuthorAction->execute($author);
    }
}
