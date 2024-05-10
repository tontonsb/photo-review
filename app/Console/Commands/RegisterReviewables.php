<?php

namespace App\Console\Commands;

use App\Models\Reviewable;
use App\Services\ReviewableService;
use Illuminate\Console\Command;

class RegisterReviewables extends Command
{
    protected $signature = 'app:register-reviewables';

    protected $description = 'Create DB entries for new files';

    public function __construct(protected ReviewableService $reviewables)
    {
        parent::__construct();
    }

    public function handle()
    {
        Reviewable::unguard();

        foreach ($this->reviewables->allFiles() as $file)
            Reviewable::firstOrCreate([
                'path' => $file->path,
            ]);

        Reviewable::reguard();
    }
}
