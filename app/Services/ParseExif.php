<?php

namespace App\Services;

class ParseExif
{
    public static function getAltitude(array $exif): float|null
    {
        $altitude = $exif['GPSAltitude'] ?? $exif['GPS']['GPSAltitude'] ?? null;

        return $altitude ? static::getFloatFromRational($altitude) : null;
    }

    public static function getFovDegrees(array $exif): float|null
    {
        $make = $exif['Make'] ?? null;
        $model = $exif['Model'] ?? null;

        return match(true) {
            'DJI' === $make && 'FC3170' === $model => 84,
            default => null,
        };
    }

    public static function getLocation(array $exif): array|null
    {
        $lat = $exif['GPSLatitude'] ?? $exif['GPS']['GPSLatitude'] ?? null;
        $latRef = $exif['GPSLatitudeRef'] ?? $exif['GPS']['GPSLatitudeRef'] ?? null;
        $lon = $exif['GPSLongitude'] ?? $exif['GPS']['GPSLongitude'] ?? null;
        $lonRef = $exif['GPSLongitudeRef'] ?? $exif['GPS']['GPSLongitudeRef'] ?? null;

        if (\in_array(null, [$lat, $latRef, $lon, $lonRef]))
            return null;

        return [
            'lat' => static::gpsCoordFromExifCoord($lat, $latRef),
            'lon' => static::gpsCoordFromExifCoord($lon, $lonRef),
        ];
    }

    protected static function gpsCoordFromExifCoord(array $exifCoords, string $ref): string
    {
        $sign = \in_array($ref, ['N', 'E']) ? 1 : -1;

        $deg = isset($exifCoords[0]) ? static::getFloatFromRational($exifCoords[0]) : 0;
        $min = isset($exifCoords[1]) ? static::getFloatFromRational($exifCoords[1]) : 0;
        $sec = isset($exifCoords[2]) ? static::getFloatFromRational($exifCoords[2]) : 0;

        return number_format($sign * ($deg + $min/60 + $sec/3600), 6);
    }

    // Usually EXIF GPS numbers are stored like 5619 / 100
    protected static function getFloatFromRational(string $rational): float
    {
        $parts = explode('/', $rational);
        $numerator = (int) ($parts[0] ?? 0);
        $denominator = (int) ($parts[1] ?? 1);

        return (float) $numerator / $denominator;
    }
}
