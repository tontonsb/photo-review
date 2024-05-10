<?php

namespace App\Services;

use App\Models\Conclusion;
use App\Models\Reviewable;
use App\Models\ReviewableFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

class ReviewableService
{
    protected Collection $files;

    public function __construct(protected ReviewerService $reviewerService) {}

    protected function files(): Collection
    {
        return $this->files ??= collect(Storage::disk('reviewables')->allFiles())
            ->filter(fn($path) => !str_starts_with($path, '.'));
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

        // Trešā prioritāte
        $reviewerToken = $this->reviewerService->getCurrentToken();
        $imgNotReviewedByCurrentReviewer = Reviewable::inRandomOrder()
            // Bildes, kuriem nav apskatījuma
            ->whereDoesntHave('reviews', fn($review) => $review
                    // no tagadējā lietotāja
                    ->where('reviewer_id', $reviewerToken)
                    // bez izlaišanas un ar vismaz 10 veltītām sekundēm
                    ->reviewed()
            )->first();

        if ($imgNotReviewedByCurrentReviewer)
            return $imgNotReviewedByCurrentReviewer;

        // Ja viss apskatīts, atgriežam jebkuru pārskatāmo bildi
        return Reviewable::inRandomOrder()->firstOrFail();
    }
}
