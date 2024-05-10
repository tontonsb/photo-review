<?php

namespace App\Http\Controllers;

use App\Models\Conclusion;
use App\Models\Review;
use App\Models\Reviewable;
use App\Models\ReviewableFile;
use App\Services\ReviewableService;
use App\Services\ReviewerService;
use Illuminate\Support\Facades\DB;

class ReviewableController
{
    public function random(ReviewableService $reviewables, ReviewerService $reviewer)
    {
        $reviewable = $reviewables->random();
        $reviewable->increment('view_count');

        return view('random', [
            'file' => $reviewable->file,
            'exif' => $reviewable->file->getData(),
            'reviewedByCurrentUser' => Review::distinct()
                ->where('reviewer_id', $reviewer->getCurrentToken())
                ->where('conclusion', '<>', Conclusion::skip)
                ->where('reviewing_duration_ms', '>', 10000)
                ->count('file'),
            'reviewableCount' => Reviewable::count(),
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
