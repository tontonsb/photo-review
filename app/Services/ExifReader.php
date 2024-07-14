<?php

namespace App\Services;

class ExifReader
{
    public static function getExif(string $path, bool $isLocal): array|null
    {
        // Try using exiftool if it's available
        try {
            $exif = $isLocal
                ? ExifTool::getLocalExif($path)
                : ExifTool::getRemoteExif($path);

            return static::formatExiftoolOutput($exif);
        } catch (\Throwable $e) {
            logger()->debug('Exiftool failed or not available. Consider installing it for better image metadata.');
        }

        // Try using PHP's exif if it's available
        try {
            $exif = exif_read_data($path);

            return static::formatPhpExifOutput($exif);
        } catch (\Throwable $e) {
            report($e);
        }

        return null;
    }

    protected static function formatExiftoolOutput(array $exif): array
    {
        // Homogenize some entries with PHP's exif
        $exif['COMPUTED'] = [
            'Width' => $exif['ImageWidth'] ?? null,
            'Height' => $exif['ImageHeight'] ?? null,
        ];

        // And some with our custom additions
        if (isset($exif['GPSLatitude'], $exif['GPSLongitude']))
            $exif['LOCATION'] = [
                'lat' => $exif['GPSLatitude'],
                'lon' => $exif['GPSLongitude'],
            ];

        if (isset($exif['GPSAltitude']))
            $exif['ALTITUDE'] = $exif['GPSAltitude'];

        if (isset($exif['GimbalYawDegree']))
            $exif['YAW'] = $exif['GimbalYawDegree'];

        // DJI's Gimbal yaw is sometimes offset, FlightYaw seems to have more correlation
        // with the actual direction of the camera
        // https://forum.dji.com/forum.php?mod=viewthread&tid=285087
        if (isset($exif['FlightYawDegree']))
            $exif['YAW'] = $exif['FlightYawDegree'];

        return $exif;
    }

    protected static function formatPhpExifOutput(array $exif): array
    {
        $location = ParseExif::getLocation($exif);
        if ($location)
            $exif['LOCATION'] = $location;

        $altitude = ParseExif::getAltitude($exif);
        if ($altitude)
            $exif['ALTITUDE'] = $altitude;

        $fov = ParseExif::getFovDegrees($exif);
        if ($fov)
            $exif['FOV'] = $fov;

        return $exif;
    }
}
