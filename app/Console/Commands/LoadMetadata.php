<?php

namespace App\Console\Commands;

use App\Models\Reviewable;
use Illuminate\Console\Command;

class LoadMetadata extends Command
{
    protected $signature = 'app:load-metadata
                            {{--all : Reload metadata for all images}}';

    protected $description = 'Load missing metadata';

    public function handle()
    {
        $reviewables = $this->option('all')
            ? Reviewable::all()
            : Reviewable::whereNull('metadata')->get();

        $this->withProgressBar($reviewables, $this->setMetadata(...));
    }

    protected function setMetadata(Reviewable $reviewable): void
    {
        $reviewable->metadata = $reviewable->file->getData();

        $reviewable->save();
    }
}
