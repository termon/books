<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Data\ReviewData;

use Illuminate\Support\Facades\Gate;
use App\Actions\Book\Review\FindReviewAction;
use App\Actions\Book\Review\DeleteReviewAction;
use App\Actions\Book\Review\CreateReviewDataAction;

class ReviewController extends Controller
{
    // GET /reviews/{id}
    public function show(int $id, FindReviewAction $action)
    {
        // authorise the view
        if (!Gate::allows('view', Review::class)) {
            return redirect()->route('login')->with('info', 'Login to view reviews');
        }

        $review = $action->execute($id);
        if (!$review) {
            return redirect()->route('books.index')->with('warning', 'Review not found');
        }
        return view('reviews.show', ['review' => $review]);
    }

    // GET /reviews/{id}/create
    public function create(int $id)
    {
        // verify user has authority to create a review
        if (!Gate::allows('create', Review::class)) {
            return redirect()->back()->with('warning', 'Not authorised');
        }

        $review = new Review;
        $review->book_id = $id;      // set review book_id

        return view('reviews.create', ['review' => $review]);
    }

    // POST /reviews/{id}
    // store a review for the book identified by $id
    public function store(int $id, ReviewData $data, CreateReviewDataAction $action)
    {
        // authorise the creation
        Gate::authorize('create', Review::class);

        // call action to handle review creation
        $review = $action->execute($id, $data);
        if (!$review) {
            return redirect()->route('books.index')->with('warning', 'Book not found');
        }

        return redirect()->route('books.show', $id)->with('info', 'Review added');
    }

    // DELETE /reviews/{id}
    public function destroy(int $id, DeleteReviewAction $deleteReview)
    {
        // authorise the creation
        Gate::authorize('delete', Review::class);

        // delete the review and return the related book
        $book = $deleteReview->execute($id);
        if (!$book) {
            return redirect()->route('books.index')->with('warning', 'Review could not be deleted');
        }
        return redirect()->route('books.show', $book->id)->with('info', 'Review deleted');
    }
}
