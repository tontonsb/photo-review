<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class CommentController
{
    public function store(Request $request, Review $review)
    {
        $review->comments()->create([
            'user_id' => auth()->id(),
            'comment' => $request->comment,
            'status' => $request->status,
        ]);

        $review->status = $request->status;
        $review->save();

        return redirect()->back(303);
    }
}
