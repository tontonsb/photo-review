<?php

namespace App\Http\Controllers;

use App\Models\Reviewer;

class ReviewerController
{
    public function index()
    {
        return view('reviewers', [
            'reviewers' => Reviewer::all(),
        ]);
    }

    public function show(Reviewer $reviewer)
    {
        return view('reviewer', [
            'reviewer' => $reviewer,
        ]);
    }
}
