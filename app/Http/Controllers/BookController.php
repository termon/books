<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Data\BookData;
use App\Models\Category;
use Illuminate\Http\Request;

use Illuminate\Validation\Rule;

use App\Actions\Book\FindBookAction;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rules\File;
use App\Actions\Book\CreateBookAction;
use App\Actions\Book\DeleteBookAction;
use App\Actions\Book\UpdateBookAction;
use App\Actions\Book\FindAllBooksAction;
use App\Actions\Book\CreateBookDataAction;
use App\Actions\Book\UpdateBookDataAction;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, FindAllBooksAction $action)
    {
        // authorise the view
        if (!Gate::allows('viewAny', Book::class)) {
            return redirect()->route('login')->with('info', 'Please Login to view books');
        }

        // extract query paramerters  $size, $sort, $direction and $search from the request
        $size = $request->input('size', 10);
        $sort = $request->input('sort', 'id');
        $direction = $request->input('direction', 'asc');
        $search = $request->query('search', null);

        $books = $action->execute($search, $sort, $direction, $size);

        return view('books.index', ['books' => $books, 'search' => $search]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(CreateBookAction $actione)
    {
        //Gate::authorize('create', Book::class); // returns 403

        if (!Gate::allows('create', Book::class)) {
            return redirect()->back()
                ->with('warning', 'Not authorised');    // returns 302
        }

        $book = new Book;
        $categories = Category::getSelectList();

        return view('books.create', ['book' => $book, 'categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BookData $data, CreateBookAction $action)
    {
        // authorise the creation
        Gate::allows('create', Book::class);

        // create the book using action
        $book = $action->execute($data->except('imageFile')->toArray());
        if (!$book) {
            return redirect()->route('books.index')->with('error', 'Book not created');
        }

        return redirect()->route('books.show', $book->id)->with('success', 'Book created successfully');
    }


    /**
     * Display the specified resource.
     */
    public function show(int $id, FindBookAction $action)
    {
        if (!Gate::allows('view', Book::class)) {
            return redirect()->route('login')->with('info', 'Please Login to view a book');
        }

        // load book from service
        $book = $action->execute($id);
        if ($book === null) {
            return redirect()->route('books.index')->with('error', 'Book not found');
        }

        return view('books.show', ['book' => $book]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id, FindBookAction  $action)
    {
        if (!Gate::allows('update', Book::class)) {
            return redirect()->route('login')->with('info', 'Please Login to edit a book');
        }

        // load the book from the service
        $book = $action->execute($id);
        if (!$book) {
            return redirect()->route('books.index')->with('error', 'Book not found');
        }
        // get the category list
        $categories = Category::getSelectList();

        return view('books.edit', ['book' => $book, 'categories' => $categories]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BookData $data, int $id, UpdateBookDataAction $action)
    {
        Gate::allows('update', Book::class);

        // update the book using the service
        $book = $action->execute($id, $data);
        if ($book === null) {
            return redirect()->route('books.index')->with('error', 'Book not found');
        }

        return redirect()->route("books.show", $id)
            ->with('success', 'Book updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id, DeleteBookAction $action)
    {
        // authorise the deletion
        Gate::authorize('delete', Book::class);

        if ($action->execute($id)) {
            return redirect()->route('books.index')->with('success', 'Book deleted successfully');
        } else {
            return redirect()->route('books.index')->with('error', 'Book not found');
        }
    }
}
