<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BookController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AuthorBookController;


Route::get('/', function () {
    return view('welcome');
})->name('home');


Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');


// Book create routes
Route::get("/books/create", [BookController::class, 'create'])->name('books.create');
Route::post("/books", [BookController::class, 'store'])->name('books.store');

// Book read routes
Route::get("/books", [BookController::class, 'index'])->name('books.index');;
Route::get('/books/{id}', [BookController::class, 'show'])->name('books.show')
    ->whereNumber('id');
Route::get('/books/{id}/download', [BookController::class, 'download'])->name('books.download')
    ->whereNumber('id');

// Book update routes
Route::get("/books/{id}/edit", [BookController::class, 'edit'])->name('books.edit')
    ->whereNumber('id');
Route::put("/books/{id}", [BookController::class, 'update'])->name('books.update')
    ->whereNumber('id');

// Book delete route
Route::delete("/books/{id}", [BookController::class, 'destroy'])->name('books.destroy')
    ->whereNumber('id');

// Review create routes
Route::get("/reviews/create/{id}", [ReviewController::class, "create"])->name("reviews.create");
Route::post("/reviews/{id}", [ReviewController::class, "store"])->name("reviews.store");

// Review read route
Route::get("/reviews/{id}", [ReviewController::class, "show"])->name("reviews.show");

// Review delete route
Route::delete("/reviews/{id}", [ReviewController::class, "destroy"])->name("reviews.destroy");


// Add Author to Book GET and POST routes
Route::get("/authorbooks/{id}/create", [AuthorBookController::class, "create"])->name("authorbooks.create");
Route::post("/authorbooks/{id}", [AuthorBookController::class, "store"])->name("authorbooks.store");

// Remove Author from Book GET and DELETE routes
Route::get("/authorbooks/{id}/delete",    [AuthorBookController::class, "delete"])->name("authorbooks.delete");
Route::delete("/authorbooks/{id}/destroy",    [AuthorBookController::class, "destroy"])->name("authorbooks.destroy");


// =======User auth routes=======
Route::post("/logout", [UserController::class, "logout"])
    ->middleware('auth')->name("logout");

Route::middleware('guest')->group(function () {
    Route::get("/register", [UserController::class, "create"])->name("register");
    Route::post("/register", [UserController::class, "store"])->name("register.store");
    Route::get("/login", [UserController::class, "login"])->name("login");
    Route::post("/login", [UserController::class, "authenticate"])->name("login.authenticate");
});
