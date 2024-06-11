<?php

namespace App\Http\Controllers;

use App\Models\Conclusion;
use App\Models\Reviewer;
use App\Services\ReviewerService;
use Carbon\CarbonInterval;

class ReviewerController
{
    public function index(ReviewerService $reviewerService)
    {
        $reviewers = Reviewer::all();
        $reviewers->loadCount([
            'reviews',
            'reviewsWithInfo',
            'reviewsWithFeedback',
        ]);

        return view('reviewers', [
            'currentToken' => $reviewerService->getCurrentToken(),
            'reviewers' => $reviewers,
        ]);
    }

    public function show(Reviewer $reviewer)
    {
        $reviews = $reviewer->reviews;

        return view('reviewer', [
            'reviewer' => $reviewer,
            'reviews' => $reviewer->reviews,
            'reviewCount' => $reviews->count(),
            'reviewedCount' => $reviews->where('conclusion', '!=', Conclusion::skip)->count(),
            'timeSpent' => CarbonInterval::milliseconds($reviews->sum('reviewing_duration_ms'))->cascade()->forHumans(['short' => true]),
        ]);
    }

    public function me(ReviewerService $reviewerService)
    {
        $reviewer = Reviewer::findOrFail($reviewerService->getCurrentToken());

        return $this->show($reviewer);
    }
}
