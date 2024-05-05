<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Services\ReviewableService;
use Illuminate\Support\Facades\DB;

class ReviewableController
{
    public function random(ReviewableService $reviewables)
    {
        return view('random', [
            'file' => $reviewables->random(),
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
        return 'photo info';
    }
}
