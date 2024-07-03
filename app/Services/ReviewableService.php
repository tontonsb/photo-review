<?php

namespace App\Services;

use App\Models\Reviewable;
use App\Models\ReviewableFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class ReviewableService
{
    protected Collection $files;

    public function __construct(protected ReviewerService $reviewerService) {}

    protected function files(): Collection
    {
        return $this->files ??= collect(Storage::disk(config('filesystems.reviewable_disk'))->allFiles())
            ->filter(fn($path) => !str_starts_with($path, '.') && !str_ends_with($path, '.kml'));
    }

    public function allFiles(): Collection
    {
        return $this->files()->map(fn($file) => new ReviewableFile($file));
    }

    public function random()
    {
        // Pirmā prioritāte — bildes bez apskatījumiem
        $imgWithNoReviews = Reviewable::inRandomOrder()
            ->doesntHave('reviews')
            ->nonTutorial()
            ->first();

        if ($imgWithNoReviews)
            return $imgWithNoReviews;

        // Otrā prioritāte — bildes bez labiem apskatījumiem
        $imgWithNoReviews = Reviewable::inRandomOrder()
            ->whereDoesntHave('reviews', fn($r) => $r->reviewed())
            ->nonTutorial()
            ->first();

        if ($imgWithNoReviews)
            return $imgWithNoReviews;

        // Trešā prioritāte — bildes, kuras tagadējais lietotājs nav redzējis
        $user = auth()->user();
        $reviewerTokens = $user
            ? $user->tokens->pluck('reviewer_id')
            : [$this->reviewerService->getCurrentToken()];

        $imgNotViewedByCurrentReviewer = Reviewable::inRandomOrder()
            ->nonTutorial()
            ->whereDoesntHave('reviews', fn($review) => $review
                ->whereIn('reviewer_id', $reviewerTokens)
            )->first();

        if ($imgNotViewedByCurrentReviewer)
            return $imgNotViewedByCurrentReviewer;

        // Ceturtā prioritāte
        $imgNotReviewedByCurrentReviewer = Reviewable::inRandomOrder()
            ->nonTutorial()
            // Bildes, kurām nav apskatījuma
            ->whereDoesntHave('reviews', fn($review) => $review
                // no tagadējā lietotāja
                ->whereIn('reviewer_id', $reviewerTokens)
                // bez izlaišanas un ar vismaz 6 veltītām sekundēm
                ->reviewed()
            )->first();

        if ($imgNotReviewedByCurrentReviewer)
            return $imgNotReviewedByCurrentReviewer;

        // Ja viss apskatīts, atgriežam jebkuru pārskatāmo bildi
        return Reviewable::inRandomOrder()->nonTutorial()->firstOrFail();
    }
}
