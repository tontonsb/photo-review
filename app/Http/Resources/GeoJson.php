<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

trait GeoJson
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type' => 'Feature',
            'geometry' => $this->geometry(),
            'properties' => $this->properties(),
        ];
    }

    protected static function newCollection($resource)
    {
        return new GeoJsonCollection($resource, static::class);
    }
}
