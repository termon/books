<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;

use Illuminate\Http\Request;

use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rules\File;
use App\Http\Requests\StoreBookRequest;
use App\Services\BookService;


class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, BookService $service)
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

        $books = $service->findAll($search, $sort, $direction, $size);

        return view('books.index', ['books' => $books, 'search' => $search]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(BookService $service)
    {
        //Gate::authorize('create', Book::class); // returns 403

        if (!Gate::allows('create', Book::class)) {
            return redirect()->back()
                ->with('warning', 'Not authorised');    // returns 302 
        }

        $book = new Book;
        $book->rating = 0;
        $categories = $service->getCategorySelectList();

        return view('books.create', ['book' => $book, 'categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, BookService $service)
    {
        Gate::allows('create', Book::class);

        // authorise the creation
        $data = $request->validate([
            'title' => ['required', 'unique:books,title'],
            'year' => ['required', 'numeric'],
            'category_id' => ['required'],
            'rating' => ['required', 'numeric', 'min:0', 'max:5'],
            'description' => ['min:0', 'max:500'],
            'image' => ['nullable', File::types(['png', 'jpg', 'jpeg', 'webp'])->max(1024)]
        ]);

        // create the book using bookservice
        $book = $service->create($data);
        if (!$book) {
            return redirect()->route('books.index')->with('error', 'Book not created');
        } 

        return redirect()->route('books.show', $book->id)->with('success', 'Book created successfully');
    }


    /**
     * Display the specified resource.
     */
    public function show(int $id, BookService $service)
    {
        if (!Gate::allows('view', Book::class)) {
            return redirect()->route('login')->with('info', 'Please Login to view a book');
        }

        // load book from service
        $book = $service->find($id);
        if ($book === null) {
            return redirect()->route('books.index')->with('error', 'Book not found');
        }

        return view('books.show', ['book' => $book]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id, BookService $service)
    {
        if (!Gate::allows('update', Book::class)) {
            return redirect()->route('login')->with('info', 'Please Login to edit a book');
        }

        // load the book from the service
        $book = $service->find($id);
        if (!$book) {
            return redirect()->route('books.index')->with('error', 'Book not found');
        }
        // get the category list
        $categories = $service->getCategorySelectList();

        return view('books.edit', ['book' => $book, 'categories' => $categories]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id, BookService $service)
    {
        Gate::allows('update', Book::class);

        // authorise the creation
        $data = $request->validate([
            'title' => ['required', Rule::unique('books')->ignore($id)],
            'category_id' => ['required'],
            'year' => ['required', 'numeric'],
            'rating' => ['required', 'numeric', 'min:0', 'max:5'],
            'description' => ['min:0', 'max:800'],
            'image' => ['nullable', File::types(['png', 'jpg', 'jpeg', 'webp'])->max(1024)],
        ]);

        // update the book using the service
        $book = $service->update($id, $data);
        if ($book === null) {
            return redirect()->route('books.index')->with('error', 'Book not found');
        }

        return redirect()->route("books.show", $id)
            ->with('success', 'Book updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id, BookService $service)
    {
        // authorise the deletion
        Gate::authorize('delete', Book::class);

        if ($service->delete($id)) {
            return redirect()->route('books.index')->with('success', 'Book deleted successfully');
        } else {
            return redirect()->route('books.index')->with('error', 'Book not found');
        }
    }
}
