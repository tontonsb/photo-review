<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewableGeoJson extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $location = $this->metadata['LOCATION'];

        if ($this->file->isSonarImage()) {
            extract(array_map(floatval(...), $location));

            $geometry = [
                'type' => 'Polygon',
                'coordinates' => [[
                    [$west, $north],
                    [$west, $south],
                    [$east, $south],
                    [$east, $north],
                    [$west, $north],
                ]],
            ];
        } else {
            $geometry = [
                'type' => 'Point',
                'coordinates' => [
                    (float) $location['lon'] ?? 0,
                    (float) $location['lat'] ?? 0,
                ],
            ];
        }

        return [
            'type' => 'Feature',
            'geometry' => $geometry,
            'properties' => [
                'is_sonar' => $this->file->isSonarImage(),
                'path' => $this->path,
                'url' => route('reviewables.review', $this->path),
            ],
        ];
    }
}
