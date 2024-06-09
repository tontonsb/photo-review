<?php

namespace App\Http\Controllers;

use App\Http\Resources\ReviewableGeoJsonCollection;
use App\Models\Review;
use App\Models\Reviewable;
use App\Models\ReviewableFile;
use App\Services\ReviewableService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class ReviewableController
{
    protected const INFOBOX_VERSION = 'v1.5.0';

    public function random(
        ReviewableService $reviewables,
        Request $request,
    ) {
        return $this->review(
            $reviewables->random(),
            $request,
        );
    }

    public function review(
        Reviewable $reviewable,
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
            'exif' => $reviewable->data,
            'reviewed_percentage' => number_format(100 * $imgWithReviews / $reviewables, 0),
            // floor to nearest hundred
            'reviewable_count' => round($reviewables - 50, -2, PHP_ROUND_HALF_DOWN),
            'seenInfobox' => $seenInfobox,
            'linkedFile' => $reviewable->file->linkedFile(),
        ]);
    }

    public function index()
    {
        $reviewCounts = Review::groupBy('file')
            ->select(
                DB::raw('count(*) as review_count'),
                DB::raw("group_concat(
                    case conclusion
                        when 'ok' then '✔️'
                        when 'suspect' then '⁉️'
                        when 'skip' then '🔄️'
                        else ''
                    end
                    || case
                        when review <> '' and review is not null then '💬'
                        else ''
                    end
                    || case
                        when problem <> '' and problem is not null then '⚠️'
                        else ''
                    end
                    || case
                        when coordinates <> '' and coordinates is not null then '📌'
                        else ''
                    end
                    || case status
                        when 'ok' then '✅'
                        when 'suspect' then '🆘'
                        when 'checkable' then '🚶'
                        when 'redo' then '📷'
                        when 'unclear' then '❔'
                        else ''
                    end
                ) as reviews"),
                'file',
            )
            ->get()
            ->keyBy('file');

        return view('reviewables', [
            'reviewables' => Reviewable::orderBy('path')->get(),
            'reviewCounts' => $reviewCounts,
        ]);
    }

    public function geojson()
    {
        return new ReviewableGeoJsonCollection(
            Reviewable::nonTutorial()
                ->whereNotNull('metadata->LOCATION')
                ->get()
                ->filter(fn($reviewable) => $reviewable->metadata)
        );
    }

    public function show(string $path)
    {
        $reviewable = new ReviewableFile($path);

        return view('reviewable', [
            'reviewable' => $reviewable,
            'reviews' => Review::where('file', $path)->get(),
        ]);
    }

    public function dir()
    {
        return view('directory', [
            'directories' => Reviewable::distinct()
                ->selectRaw("substr(path, 1, instr(path, '/')) as dir")
                ->pluck('dir'),
        ]);
    }
}
