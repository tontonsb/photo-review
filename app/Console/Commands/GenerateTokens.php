<?php

namespace App\Console\Commands;

use App\Models\Reviewable;
use App\Models\Reviewer;
use App\Models\ReviewerToken;
use Illuminate\Console\Command;

class GenerateTokens extends Command
{
    protected $signature = 'app:generate-tokens';

    protected $description = 'Create missing transfer tokens';

    public function handle()
    {
        $reviewers = Reviewer::all();

        $this->withProgressBar($reviewers, $this->generate(...));
    }

    protected function generate(Reviewer $reviewer): void
    {
        ReviewerToken::getOrRegister($reviewer->reviewer_id);
    }
}
