<?php

namespace App\Http\Controllers;

use App\Actions\AddReviewAction;
use App\Actions\Book\Review\CreateReviewAction;
use App\Actions\Book\Review\DeleteReviewAction;
use App\Actions\Book\Review\FindReviewAction;
use App\Actions\DestroyReviewAction;
use App\Models\Book;
use App\Models\Review;
use App\Services\ReviewService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ReviewController extends Controller
{
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



    // store a review for the book identified by $id
    public function store(Request $request, int $id, CreateReviewAction $action)
    {
        // authorise the creation
        Gate::authorize('create', Review::class);

        $data = $request->validate([
            'name' => ['required'],
            'rating' => ['required', 'numeric', 'min:0', 'max:5'],
            'comment' => ['required', 'min:0', 'max:500']
        ]);

        // call action to handle review creation
        $review = $action->execute($id, $data);
        if (!$review) {
            return redirect()->route('books.index')->with('warning', 'Book not found');
        }

        return redirect()->route('books.show', $id)->with('info', 'Review added');
    }

    public function destroy(int $id, FindReviewAction $findReview, DeleteReviewAction $deleteReview)
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
