<?php

namespace App\Http\Controllers;

use App\Models\Reviewer;
use App\Services\ReviewerService;

class ReviewerController
{
    public function index(ReviewerService $reviewerService)
    {
        return view('reviewers', [
            'currentToken' => $reviewerService->getCurrentToken(),
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
