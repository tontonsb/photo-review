<?php

namespace App\Console\Commands;

use App\Models\Reviewable;
use Illuminate\Console\Command;

class LoadMetadata extends Command
{
    protected $signature = 'app:load-metadata
                            {--all : Reload metadata for all images}
                            {--missing-loc : Reload metadata for images without locations}';

    protected $description = 'Load missing metadata';

    public function handle()
    {
        $reviewables = $this->option('all') || $this->option('missing-loc')
            ? Reviewable::all()
            : Reviewable::whereNull('metadata')->get();

        if ($this->option('missing-loc'))
            $reviewables = $reviewables->filter(fn($r) => !isset($r->metadata['LOCATION']));

        $this->withProgressBar($reviewables, $this->setMetadata(...));
    }

    protected function setMetadata(Reviewable $reviewable): void
    {
        $reviewable->metadata = $reviewable->file->getData();

        $reviewable->save();
    }
}
