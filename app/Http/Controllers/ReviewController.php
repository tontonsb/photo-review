<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Reviewable;
use App\Services\ReviewerService;
use Illuminate\Http\Request;

class ReviewController
{
    public function index(Request $request)
    {
        $reviews = Review::latest()
            ->when(
                $request->has('problems'),
                fn($reviews) => $reviews->whereNotNull('problem')
            )
            ->when(
                $request->has('reviews'),
                fn($reviews) => $reviews->whereNotNull('review')
            )
            ->when(
                $request->has('pins'),
                fn($reviews) => $reviews->whereNotNull('coordinates')
            )
            ->cursorPaginate($request->pagesize ?? 20)
            ->withQueryString();

        return view('reviews', ['reviews' => $reviews]);
    }

    public function show(Review $review)
    {
        $file = $review->reviewableFile;

        return view('review', [
            'review' => $review,
            'file' => $file,
            'exif' => $file->getData(),
        ]);
    }

    public function store(Request $request, ReviewerService $reviewer)
    {
        Review::create([
            'reviewer_id' => $reviewer->getCurrentToken(),
            'file' => $request->filepath,
            'conclusion' => $request->conclusion,
            'review' => $request->review,
            'problem' => $request->problem,
            'reviewing_duration_ms' => $request->reviewing_duration_ms,
            'coordinates' => $request->coordinates ? $this->extractCoordinates($request->coordinates) : null,
        ]);

        rescue(fn() => Reviewable::find($request->filepath)->increment('review_count'));

        if ('next' === $request->mode) {
            $next = Reviewable::orderBy('path')
                ->where('path', '>', $request->filepath)
                ->first();

            if ($next)
                return to_route('reviewables.review', $next, 303);
        }

        return to_route('reviewables.random', status: 303);
    }

    /**
     * Patīrīsim, lai saglabājam tikai jēdzīgus un lietojamus datus.
     */
    protected function extractCoordinates(string $requestCoordinates): ?array
    {
        $requestCoordinates = json_decode($requestCoordinates);
        $coordinates = [];

        foreach ($requestCoordinates as $coords)
            if (is_array($coords) && 2 == count($coords))
                $coordinates[] = [
                    (float) $coords[0],
                    (float) $coords[1],
                ];

        // Neglabāsim tukšus masīvus
        return $coordinates ?: null;
    }
}
