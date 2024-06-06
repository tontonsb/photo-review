<?php

namespace App\Services;

use Illuminate\Support\Facades\Process;

class ExifTool
{
    /**
     * Exiftool options
     * -fast only reads the file start without loading the whole file
     * -j formats output as json
     * -n skips formatting numbers, e.g. we get GPSLongitude: 23.5216960833333 instead of 23 deg 31' 18.11" E
     */
    protected static string $options = '-fast -j -n';

    public static function getLocalExif($path): array
    {
        $result = Process::run('exiftool '.static::$options.' '.$path);

        if (!$result->successful())
            throw new \RuntimeException(
                'Running exiftool failed: '.$result->output(),
                $result->exitCode
            );

        return static::parse($result->output());
    }

    public static function getRemoteExif($path): array
    {
        $result = Process::run('curl -s '.$path.' | exiftool '.static::$options.' -');

        if (!$result->successful())
            throw new \RuntimeException(
                'Running exiftool failed: '.$result->output(),
                $result->exitCode
            );

        return static::parse($result->output());
    }

    protected static function parse(string $exif): array
    {
        return json_decode($exif, true)[0] ?? [];
    }
}
