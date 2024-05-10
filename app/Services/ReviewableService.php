<?php

namespace App\Services;

use App\Models\Reviewable;
use App\Models\ReviewableFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

class ReviewableService
{
    protected Collection $files;

    protected function files(): Collection
    {
        return $this->files ??= collect(Storage::disk('reviewables')->allFiles())
            ->filter(fn($path) => !str_starts_with($path, '.'));
    }

    public function allFiles(): Collection
    {
        return $this->files()->map(fn($file) => new ReviewableFile($file));
    }

    public function random()
    {
        // TODO: nāktonē, ja būs lietojums un dati, var
        // - palielināt varbūtību failiem, ko neviens nav reviewojis
        // - samazināt varbūtību failiem, ko pats jau esi reviewojis
        // - blacklistot problemātiskos failus
        $file = $this->files()->random();

        if (!$file)
            throw new RuntimeException('No visible files in the `reviewables` disk.');

        return new ReviewableFile(
            $file,
        );
    }
}
