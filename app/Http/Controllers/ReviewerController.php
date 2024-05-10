<?php

namespace App\Http\Controllers;

use App\Models\Review;

class ReviewerController
{
    public function index()
    {
        $reviewers = Review::groupBy('reviewer_id')
            ->select('reviewer_id')
            ->selectRaw('count(*) as review_count')
            ->get();

        return view('reviewers', ['reviewers' => $reviewers]);
    }

    public function show(string $id)
    {
        return view('reviewer', [
            'reviewerId' => $id,
            'reviews' => Review::where('reviewer_id', $id)->get(),
        ]);
    }
}
