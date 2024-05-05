<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReviewController
{
    public function index()
    {
        return 'paginated review list';
    }

    public function store()
    {
        return 'store a review';
    }
}
