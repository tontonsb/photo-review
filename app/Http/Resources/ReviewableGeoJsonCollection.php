<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ReviewableGeoJsonCollection extends ResourceCollection
{
    public static $wrap = 'features';

    /**
     * Get additional data that should be returned with the resource array.
     *
     * @return array<string, mixed>
     */
    public function with(Request $request): array
    {
        return [
            'type' => 'FeatureCollection',
        ];
    }
}
