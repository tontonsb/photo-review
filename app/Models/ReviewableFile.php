<?php

namespace App\Models;

use App\Services\ExifReader;
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

    public function linkedFile(): ?static
    {
        if (!$this->isSonarImage())
            return null;

        if ($this->isSrc())
            return new static(
                str_replace('-src.png', '-original.png', $this->path)
            );

        return new static(
            str_replace('-original.png', '-src.png', $this->path)
        );
    }

    public function isSrc(): ?bool
    {
        if (!$this->isSonarImage())
            return null;

        return str_ends_with($this->path, '-src.png');
    }

    protected function loadData(): array
    {
        $path = $this->isLocal() ? $this->disk->path($this->path) : $this->disk->url($this->path);

        $exif = ExifReader::getExif($path, $this->isLocal());

        if ($exif)
            $exif = $this->addExtent($exif);

        if (!$exif) {
            $exif = array_merge($exif, [
                'FileName' => basename($path),
                'FileDateTime' => $this->disk->lastModified($this->path),
                'FileSize' => $this->disk->size($this->path),
                'MimeType' => $this->disk->mimeType($this->path),
            ]);

            try {
                foreach (getimagesize($path) ?? [] as $key => $value)
                    match($key) {
                        0 => $exif['COMPUTED']['Width'] = $value,
                        1 => $exif['COMPUTED']['Height'] = $value,
                        2 => ($exif['FileType'] = $value) && $exif['COMPUTED']['ByteOrderMotorola'] = (int) (\IMAGETYPE_TIFF_MM === $value),
                        3 => $exif['COMPUTED']['html'] = $value,
                        'mime' => $exif['MimeType'] = $value,
                        'bits' => $exif['Bits'] = $value,
                        // 'channels' => 3 -> rgb, 4 -> cmyk
                        default => $exif[$key] = $value,
                    };
            } catch(\Throwable) {
                //
            }
        }

        // Special handling for sonar images that have an associated .kml
        if ($this->isSonarImage()) {
            try {
                $location = $this->getLocationFromKml();
                $exif['LOCATION'] = $location;
            } catch(\Throwable) {
                //
            }
        }

        return $exif;
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

    protected function addExtent(array $exif): array
    {
        if (!isset(
            $exif['FOV'],
            $exif['ALTITUDE'],
            $exif['COMPUTED']['Width'],
            $exif['COMPUTED']['Height'],
        ))
            return $exif;

        // assume pitch is good unless we know it isn't
        $pitchIsVertical = true;
        if ($exif['GimbalPitchDegree'] ?? false)
            $pitchIsVertical = abs($exif['GimbalPitchDegree']) > 80
                && abs($exif['GimbalPitchDegree']) < 100;

        if (!$pitchIsVertical)
            return $exif;

        // TODO: get more correct elevation data based on position
        // For now take something close to median height in the target area
        $height = $exif['ALTITUDE'] - 4;

        $fovMeters = 2 * $height * tan(deg2rad($exif['FOV']) / 2);
        $scale = $fovMeters / $exif['COMPUTED']['Width'];

        $exif['EXTENT'] = [
            'scale' => $scale,
            'width' => $fovMeters,
            'height' => $scale * $exif['COMPUTED']['Height'],
        ];

        return $exif;
    }

    protected function isLocal(): bool
    {
        return $this->disk->getAdapter() instanceof \League\Flysystem\Local\LocalFilesystemAdapter;
    }

    public function isSonarImage(): bool
    {
        return str_ends_with($this->path, '.png')
            && str_contains($this->path, 'Sonar');
    }
}
