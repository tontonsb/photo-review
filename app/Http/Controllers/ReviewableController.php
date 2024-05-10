<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Reviewable;
use App\Models\ReviewableFile;
use App\Services\ReviewableService;
use Illuminate\Support\Facades\DB;

class ReviewableController
{
    public function random(ReviewableService $reviewables)
    {
        $reviewable = $reviewables->random();
        $reviewable->increment('view_count');

        return view('random', [
            'file' => $reviewable->file,
            'exif' => $reviewable->file->getData(),
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
