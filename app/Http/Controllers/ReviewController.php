<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Services\ReviewerService;
use Illuminate\Http\Request;

class ReviewController
{
    public function index()
    {
        return 'paginated review list';
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
