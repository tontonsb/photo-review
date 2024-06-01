<?php

namespace App\Models;

use App\Services\ExifTool;
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

    public function linkedFile(): ?ReviewableFile
    {
        if (!$this->isSonarImage())
            return null;

        if ($this->isSrc())
            return new ReviewableFile(
                str_replace('-src.png', '-original.png', $this->path)
            );

        return new ReviewableFile(
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

        try {

            $exif = exif_read_data($path);

            // Needs a locally installed exiftool
            // e.g. `sudo apt install libimage-exiftool-perl`
            try {
                $preciseExif = $this->isLocal()
                    ? ExifTool::getLocalExif($path)
                    : ExifTool::getRemoteExif($path);
            } catch (\Throwable $e) {
                report($e);

                $preciseExif = null;
            }

            if ($exif) {
                $data = [];

                $location = ParseExif::getLocation($exif);
                if ($location)
                    $data['LOCATION'] = $location;

                $altitude = ParseExif::getAltitude($exif);
                if ($altitude)
                    $data['ALTITUDE'] = $altitude;

                if ($preciseExif['Gimbal Yaw Degree'] ?? false)
                    $data['YAW'] = $preciseExif['Gimbal Yaw Degree'];

                // assume pitch is good unless we know it isn't
                $pitchIsVertical = true;
                if ($preciseExif['Gimbal Pitch Degree'] ?? false)
                    $pitchIsVertical = abs($preciseExif['Gimbal Pitch Degree']) > 80;

                if ($pitchIsVertical) {
                    $fov = ParseExif::getFovDegrees($exif);
                    $widthPixels = $exif['COMPUTED']['Width'] ?? null;
                    $heightPixels = $exif['COMPUTED']['Height'] ?? null;
                    if ($fov && $widthPixels && $heightPixels) {
                        // TODO: get more correct elevation data based on position
                        // For now take something close to median height in the target area
                        $height = $altitude - 4;

                        $fovMeters = 2 * $height * tan(deg2rad($fov) / 2);
                        $scale = $fovMeters / $widthPixels;

                        $data['EXTENT'] = [
                            'scale' => $scale,
                            'width' => $fovMeters,
                            'height' => $scale * $heightPixels,
                        ];
                    }
                }

                $data += $exif;

                return $data;
            }
        } catch(\Throwable) {}

        $data = [];

        // Special handling for sonar images that have an associated .kml
        if ($this->isSonarImage()) {
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

    public function isSonarImage(): bool
    {
        return str_ends_with($this->path, '.png')
            && str_contains($this->path, 'Sonar');
    }
}
