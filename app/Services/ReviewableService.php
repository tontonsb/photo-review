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
            ->first();

        if ($imgWithNoReviews)
            return $imgWithNoReviews;

        // Otrā prioritāte — bildes bez labiem apskatījumiem
        $imgWithNoReviews = Reviewable::inRandomOrder()
            ->whereDoesntHave('reviews', fn($r) => $r->reviewed())
            ->first();

        if ($imgWithNoReviews)
            return $imgWithNoReviews;

        // Trešā prioritāte — bildes, kuras tagadējais lietotājs nav redzējis
        $reviewerToken = $this->reviewerService->getCurrentToken();
        $imgNotViewedByCurrentReviewer = Reviewable::inRandomOrder()
            ->whereDoesntHave('reviews', fn($review) => $review
                ->where('reviewer_id', $reviewerToken)
            )->first();

        if ($imgNotViewedByCurrentReviewer)
            return $imgNotViewedByCurrentReviewer;

        // Ceturtā prioritāte
        $imgNotReviewedByCurrentReviewer = Reviewable::inRandomOrder()
            // Bildes, kurām nav apskatījuma
            ->whereDoesntHave('reviews', fn($review) => $review
                    // no tagadējā lietotāja
                    ->where('reviewer_id', $reviewerToken)
                    // bez izlaišanas un ar vismaz 6 veltītām sekundēm
                    ->reviewed()
            )->first();

        if ($imgNotReviewedByCurrentReviewer)
            return $imgNotReviewedByCurrentReviewer;

        // Ja viss apskatīts, atgriežam jebkuru pārskatāmo bildi
        return Reviewable::inRandomOrder()->firstOrFail();
    }
}
