<?php

namespace App\Console\Commands;

use App\Models\Reviewable;
use Illuminate\Console\Command;

class LoadMetadata extends Command
{
    protected $signature = 'app:load-metadata';

    protected $description = 'Load missing metadata';

    public function handle()
    {
        $reviewables = Reviewable::whereNull('metadata')->get();

        $this->withProgressBar($reviewables, $this->setMetadata(...));
    }

    protected function setMetadata(Reviewable $reviewable): void
    {
        $reviewable->metadata = $reviewable->file->getData();

        $reviewable->save();
    }
}
