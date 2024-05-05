<?php

namespace App\Http\Controllers;

use App\Services\ReviewableService;

class ReviewableController
{
    public function random(ReviewableService $reviewables)
    {
        return view('random', [
            'file' => $reviewables->random(),
        ]);
    }

    public function index()
    {
        return 'photo list with info';
    }

    public function show(string $path)
    {
        return 'photo info';
    }
}
