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
        return $this->data ??= exif_read_data($this->disk->path($this->path));
    }
}
