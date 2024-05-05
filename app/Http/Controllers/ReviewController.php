<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Services\ReviewerService;
use Illuminate\Http\Request;

class ReviewController
{
    public function index(Request $request)
    {
        $reviews = Review::latest()
            ->when(
                $request->has('problems'),
                fn($reviews) => $reviews->whereNotNull('problem')
            )
            ->when(
                $request->has('reviews'),
                fn($reviews) => $reviews->whereNotNull('review')
            )
            ->cursorPaginate($request->pagesize ?? 20)
            ->withQueryString();

        return view('reviews', ['reviews' => $reviews]);
    }

    public function store(Request $request, ReviewerService $reviewer)
    {
        Review::create([
            'reviewer_id' => $reviewer->getCurrentToken(),
            'file' => $request->filepath,
            'review' => $request->review,
            'problem' => $request->problem,
        ]);

        return to_route('reviewables.random', status: 303);
    }
}
