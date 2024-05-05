<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PhotoController
{
    public function random()
    {
        return 'a random photo';
    }

    public function index()
    {
        return 'photo list with info';
    }

    public function show(string $photo)
    {
        return 'photo info';
    }
}
