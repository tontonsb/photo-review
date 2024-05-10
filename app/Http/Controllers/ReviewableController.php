<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Reviewable;
use App\Services\ReviewableService;
use Illuminate\Support\Facades\DB;

class ReviewableController
{
    public function random(ReviewableService $reviewables)
    {
        $file = $reviewables->random();

        return view('random', [
            'file' => $file,
            'exif' => $file->getData(),
        ]);
    }

    public function index(ReviewableService $reviewables)
    {
        // TODO: paginate, ja vajadzēs. un vrb filtrēt pēc kkā
        $reviewCounts = Review::groupBy('file')
            ->select(
                DB::raw('count(*) as review_count'),
                'file',
            )
            ->pluck('review_count', 'file');

        return view('reviewables', [
            'reviewables' => $reviewables->all()->sortBy('path'),
            'reviewCounts' => $reviewCounts,
        ]);
    }

    public function show(string $path)
    {
        $reviewable = new Reviewable($path);

        return view('reviewable', [
            'reviewable' => $reviewable,
            'reviews' => Review::where('file', $path)->get(),
        ]);
    }
}
