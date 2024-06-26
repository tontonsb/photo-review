<?php

namespace App\Http\Resources;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewGeoJson extends JsonResource
{
    use GeoJson;

    protected function geometry(): array
    {
        $file = $this->reviewableFile;
        $location = $file->getData()['LOCATION'];

        if ($file->isSonarImage()) {
            extract(array_map(floatval(...), $location));

            // TODO: get more precise areas from https://sonar.glaive.pro/kml/Areas.kml
            return [
                'type' => 'Polygon',
                'coordinates' => [[
                    [$west, $north],
                    [$west, $south],
                    [$east, $south],
                    [$east, $north],
                    [$west, $north],
                ]],
            ];
        }

        return [
            'type' => 'Point',
            'coordinates' => [
                (float) $location['lon'] ?? 0,
                (float) $location['lat'] ?? 0,
            ],
        ];
    }

    protected function properties(): array
    {
        return [
            'id' => $this->id,
            'url' => route('reviews.show', $this),
            'conclusion' => $this->conclusion?->icon(),
            'status' => $this->status?->icon(),
        ];
    }
}
