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
        // TODO: nāktonē, ja būs lietojums un dati, var
        // - palielināt varbūtību failiem, ko neviens nav reviewojis
        // - samazināt varbūtību failiem, ko pats jau esi reviewojis
        // - blacklistot problemātiskos failus
        $file = $this->files()->random();

        if (!$file)
            throw new RuntimeException('No visible files in the `reviewables` disk.');

        return new Reviewable(
            $file,
            asset($this->disk->url($file)),
            // TODO: varētu exif info padot, lai var lokāciju utml apskatīt. vai arī Reviewablē viņu ielādēt
        );
    }
}
