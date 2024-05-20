<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Reviewable;
use App\Models\ReviewableFile;
use App\Services\ReviewableService;
use App\Services\ReviewerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class ReviewableController
{
    protected const INFOBOX_VERSION = 'v1.0.0';

    public function random(
        ReviewableService $reviewables,
        ReviewerService $reviewer,
        Request $request,
    ) {
        return $this->review(
            $reviewables->random(),
            $reviewer,
            $request,
        );
    }

    public function review(
        Reviewable $reviewable,
        ReviewerService $reviewer,
        Request $request,
    ) {
        $reviewable->increment('view_count');

        $seenInfobox = $request->cookie('seen_infobox') === static::INFOBOX_VERSION;
        Cookie::queue(
            Cookie::forever('seen_infobox', static::INFOBOX_VERSION)
        );

        $imgWithReviews = Reviewable::whereHas('reviews', fn($r) => $r->reviewed())->count();
        $reviewables = Reviewable::count();

        return view('random', [
            'file' => $reviewable->file,
            'exif' => $reviewable->file->getData(),
            'reviewed_percentage' => number_format(100 * $imgWithReviews / $reviewables, 0),
            /* 'reviewedByCurrentUser' => Review::distinct()
                ->where('reviewer_id', $reviewer->getCurrentToken())
                ->reviewed()
                ->count('file'),
            */
            'seenInfobox' => $seenInfobox,
            'linkedFile' => $reviewable->file->linkedFile(),
        ]);
    }

    public function index()
    {
        // TODO: paginate, ja vajadzēs. un vrb filtrēt pēc kkā
        $reviewCounts = Review::groupBy('file')
            ->select(
                DB::raw('count(*) as review_count'),
                'file',
            )
            ->pluck('review_count', 'file');

        return view('reviewables', [
            'reviewables' => Reviewable::orderBy('path')->get(),
            'reviewCounts' => $reviewCounts,
        ]);
    }

    public function show(string $path)
    {
        $reviewable = new ReviewableFile($path);

        return view('reviewable', [
            'reviewable' => $reviewable,
            'reviews' => Review::where('file', $path)->get(),
        ]);
    }
}
