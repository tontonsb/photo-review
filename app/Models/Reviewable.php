<?php

namespace App\Models;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;

class Reviewable
{
    protected Filesystem $disk;
    public readonly string $url;

    protected $data;

    public function __construct(
        public readonly string $path,
    ) {
        $this->disk = Storage::disk('reviewables');

        $this->url = asset($this->disk->url($this->path));
    }

    public function getData(): array
    {
        return $this->data ??= $this->loadData();
    }

    protected function loadData(): array
    {
        $path = $this->disk->path($this->path);

        try {
            $data = exif_read_data($path);

            if ($data)
                return $data;
        } catch(\Throwable) {}

        $data = [
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
}
