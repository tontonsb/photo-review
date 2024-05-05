<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReviewableController
{
    public function random()
    {
        return 'a random photo';
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
