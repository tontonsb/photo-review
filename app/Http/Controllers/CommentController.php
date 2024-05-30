<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CommentController
{
    public function store(Request $request, Review $review)
    {
        $request->validate([
            'status' => ['required', Rule::enum(Status::class)],
            'comment' => ['required', 'string'],
        ]);

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
