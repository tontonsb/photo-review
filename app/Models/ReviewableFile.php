<?php

namespace App\Models;

use App\Services\ParseExif;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use SimpleXMLElement;

class ReviewableFile
{
    protected Filesystem $disk;
    public readonly string $url;

    protected $data;

    public function __construct(
        public readonly string $path,
    ) {
        $this->disk = Storage::disk(config('filesystems.reviewable_disk'));

        $url = $this->disk->url($this->path);
        $this->url = $this->isLocal() ? asset($url) : $url;
    }

    public function getData(): array
    {
        return $this->data ??= $this->loadData();
    }

    protected function loadData(): array
    {
        $path = $this->isLocal() ? $this->disk->path($this->path) : $this->disk->url($this->path);

        try {
            $exif = exif_read_data($path);

            if ($exif) {
                if ($location = ParseExif::getLocation($exif))
                    return [
                        'LOCATION' => $location,
                        ...$exif,
                    ];

                return $exif;
            }
        } catch(\Throwable) {}

        $data = [];

        // Special handling for sonar images that have an associated .kml
        if (str_ends_with($this->path, '.png')) {
            try {
                $location = $this->getLocationFromKml();
                $data['LOCATION'] = $location;
            } catch(\Throwable) {}
        }

        $data = [
            ...$data,
            'FileName' => basename($path),
            'FileDateTime' => $this->disk->lastModified($this->path),
            'FileSize' => $this->disk->size($this->path),
            'MimeType' => $this->disk->mimeType($this->path),
        ];

        try {
            foreach (getimagesize($path) ?? [] as $key => $value)
                match($key) {
                    0 => $data['COMPUTED']['Width'] = $value,
                    1 => $data['COMPUTED']['Height'] = $value,
                    2 => ($data['FileType'] = $value) && $data['COMPUTED']['ByteOrderMotorola'] = (int) (IMAGETYPE_TIFF_MM === $value),
                    3 => $data['COMPUTED']['html'] = $value,
                    'mime' => $data['MimeType'] = $value,
                    'bits' => $data['Bits'] = $value,
                    // 'channels' => 3 -> rgb, 4 -> cmyk
                    default => $data[$key] = $value,
                };
        } catch(\Throwable) {}

        return $data;
    }

    protected function getLocationFromKml(): array
    {
        $kmlFile = $this->disk->url(
            str_replace('.png', '.kml', $this->path)
        );
        $kmlString = file_get_contents($kmlFile);
        $kml = new SimpleXMLElement($kmlString);

        return (array) $kml->Folder->GroundOverlay->LatLonBox;
    }

    protected function isLocal(): bool
    {
        return $this->disk->getAdapter() instanceof \League\Flysystem\Local\LocalFilesystemAdapter;
    }
}
