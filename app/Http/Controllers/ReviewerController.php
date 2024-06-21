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

    public function show(Reviewer $reviewer, ReviewerService $reviewerService)
    {
        $reviews = $reviewer->reviews;

        return view('reviewer', [
            'reviewer' => $reviewer,
            'reviews' => $reviews,
            'reviewCount' => $reviews->count(),
            'reviewedCount' => $reviews->where('conclusion', '!=', Conclusion::skip)->count(),
            'timeSpent' => CarbonInterval::milliseconds($reviews->sum('reviewing_duration_ms'))->cascade()->forHumans(['short' => true]),
            'reviewerService' => $reviewerService,
        ]);
    }

    public function me(ReviewerService $reviewerService)
    {
        $reviewer = Reviewer::find($reviewerService->getCurrentToken());

        if (!$reviewer) {
            abort(404, 'Šajā ierīcē tev pārskatījumu vēl nav');
        }

        return $this->show($reviewer, $reviewerService);
    }
}
