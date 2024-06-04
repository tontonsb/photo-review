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
        $isSonar = $this->file->isSonarImage();

        if ($isSonar) {
            extract(array_map(floatval(...), $location));

            // TODO: get more precise areas from https://sonar.glaive.pro/kml/Areas.kml
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
                'is_sonar' => $isSonar,
                'path' => $this->path,
                'url' => route('reviewables.review', $this->path),
                'altitude_meters' => $this->when(!$isSonar, $this->metadata['ALTITUDE'] ?? null),
                'bearing_degrees' => $this->when(!$isSonar, isset($this->metadata['YAW']) ? (float) $this->metadata['YAW'] : null),
                'width_guess_meters' => $this->when(!$isSonar, $this->metadata['EXTENT']['width'] ?? null),
                'height_guess_meters' => $this->when(!$isSonar, $this->metadata['EXTENT']['height'] ?? null),
            ],
        ];
    }
}
