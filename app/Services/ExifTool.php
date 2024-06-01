<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Process;

class ExifTool
{
    public static function getLocalExif($path): Collection
    {
        $result = Process::run('exiftool '.$path);

        if (!$result->successful())
            throw new \RuntimeException(
                'Running exiftool failed: '.$result->output(),
                $result->exitCode
            );

        return static::parse($result->output());
    }

    public static function getRemoteExif($path): Collection
    {
        $result = Process::run('curl -s '.$path.' | exiftool -fast -');

        if (!$result->successful())
            throw new \RuntimeException(
                'Running exiftool failed: '.$result->output(),
                $result->exitCode
            );

        return static::parse($result->output());
    }

    protected static function parse(string $exif): Collection
    {
        return collect(explode("\n", $exif))
            ->filter(fn($row) => str_contains($row, ':'))
            ->mapWithKeys(function($row) {
                [$key, $value] = explode(':', $row, 2);

                return [trim($key) => trim($value)];
            });
    }
}
