<?php

namespace App\Services;

use App\Models\Book;
use App\Models\Author;

use App\Actions\Book\Author\AddAuthorAction;
use App\Actions\Book\Author\RemoveAuthorAction;

class AuthorBookService
{

    private $addAuthorAction;
    private $removeAuthorAction;

    public function __construct()
    {

        $this->addAuthorAction = new AddAuthorAction();
        $this->removeAuthorAction = new RemoveAuthorAction();
    }


    public function addAuthorToBook(int|Book|null $book, int|Author|null $author): ?Book
    {
        return $this->addAuthorAction->execute($book, $author);
    }

    public function removeAuthorFromBook(int|Book|null $book, int|Author|null $author): ?Book
    {
        return $this->removeAuthorAction->execute($book, $author);
    }
}
