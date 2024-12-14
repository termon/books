<?php

namespace App\Http\Controllers;

use App\Actions\Book\Author\AddAuthorToBookAction;
use App\Actions\Book\Author\RemoveAuthorFromBookAction;
use App\Actions\Book\FindBookAction;
use App\Models\Book;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AuthorBookController extends Controller
{
    // GET – display form to add author to book {id}
    public function create($id, FindBookAction $findBook)
    {
        if (!Gate::allows('update', Book::class)) {
            return redirect()->route('login')->with('info', 'Please Login to edit a book');
        }

        $book = $findBook->execute($id);
        if (!isset($book)) {
            return redirect()->route('books.index')
                ->with('warning', "Book {$id} does not exist!");
        }

        // make select list of authors who can be added to this book
        $authors = $book->addAuthorBookSelectList();

        return view('authorbook.create', ['book' => $book, 'authors' => $authors]);
    }


    // POST – add author in form request to book {id}
    public function store(int $id, Request $request, AddAuthorToBookAction $action)
    {
        if (!Gate::allows('update', Book::class)) {
            return redirect()->route('login')->with('info', 'Please Login to edit a book');
        }

        // validate request
        $data = $request->validate(
            ['author_id' => ['required']],
            ['author_id' => 'Select an author']
        );

        // add author to book
        $book = $action->execute($id, $data['author_id']);
        if (!isset($book)) {
            return redirect()->route('books.index')->with('warning', "Book {$id} does not exist!");
        }

        // redirect to display updated book
        return redirect()->route('books.show', ['id' => $id])
            ->with('success', "Author Added!");
    }

    // GET – display form to remove author from book {id}
    public function delete(int $id, FindBookAction $findBook)
    {
        if (!Gate::allows('update', Book::class)) {
            return redirect()->route('login')->with('info', 'Please Login to edit a book');
        }

        $book = $findBook->execute($id);
        if (!isset($book)) {
            return redirect()->route('books.index')
                ->with('warning', "Book {$id} does not exist!");
        }

        // make select list of authors who can be removed from this book
        $authors = $book->removeAuthorBookSelectList();

        // return the view passing the book and authors select list
        return view('authorbook.delete', ['book' => $book, 'authors' => $authors]);
    }

    // DELETE – remove author in form request from book {id}
    public function destroy(int $id, Request $request, RemoveAuthorFromBookAction $action)
    {
        if (!Gate::allows('update', Book::class)) {
            return redirect()->route('login')->with('info', 'Please Login to edit a book');
        }

        $data = $request->validate(
            ['author_id' => ['required']],
            ['author_id' => 'Select author']
        );

        // locate book
        $book = $action->execute($id, $data['author_id']);
        if (!isset($book)) {
            return redirect()->route('books.index')->with('warning', "Book {$id} does not exist!");
        }

        // redirect to show updated book
        return redirect()->route('books.show', ['id' => $id])
            ->with('success', "Author removed!");
    }
}
