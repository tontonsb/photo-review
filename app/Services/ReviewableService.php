<?php

namespace App\Services;

use App\Models\Reviewable;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Collection;
use RuntimeException;

class ReviewableService
{
    protected Collection $files;

    public function __construct(protected Filesystem $disk) {}

    public function files(): Collection
    {
        return $this->files ??= collect($this->disk->allFiles())
            ->filter(fn($path) => !str_starts_with($path, '.'));
    }

    public function random()
    {
        $file = $this->files()->random();

        if (!$file)
            throw new RuntimeException('No visible files in the `reviewables` disk.');

        return new Reviewable($file, $this->disk->url($file));
    }
}
