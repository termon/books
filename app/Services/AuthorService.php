<?php

namespace App\Services;

use App\Models\Author;
use App\Actions\Author\FindAuthorAction;
use App\Actions\Author\CreateAuthorAction;
use App\Actions\Author\DeleteAuthorAction;

class AuthorService
{

    public function __construct(
        private CreateAuthorAction $addAuthorAction = new CreateAuthorAction(),
        private DeleteAuthorAction $deleteAuthorAction = new DeleteAuthorAction(),
        private FindAuthorAction $findAuthorAction = new FindAuthorAction()
    ) {}

    public function find(int $id): Author | null
    {
        return $this->findAuthorAction->execute($id);
    }

    public function create(array $data): ?Author
    {
        return $this->addAuthorAction->execute($data);
    }

    public function delete(int|Author|null $author): bool
    {
        return $this->deleteAuthorAction->execute($author);
    }
}
