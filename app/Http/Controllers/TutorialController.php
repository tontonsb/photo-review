<?php

namespace App\Http\Controllers;

use App\Models\Reviewable;

class TutorialController
{
    public function index()
    {
        $reviewable = Reviewable::tutorial()
            ->orderBy('tutorial_order')
            ->firstOrFail();

        return to_route('tutorial.show', $reviewable, 303);
    }

    public function show(Reviewable $reviewable)
    {
        $reviewable->increment('view_count');

        return view('tutorial', [
            'reviewable' => $reviewable,
            'file' => $reviewable->file,
            'exif' => $reviewable->data,
            'prev' => Reviewable::tutorial()
                ->orderBy('tutorial_order', 'desc')
                ->where('tutorial_order', '<', $reviewable->tutorial_order)
                ->first(),
            'next' => Reviewable::tutorial()
                ->orderBy('tutorial_order')
                ->where('tutorial_order', '>', $reviewable->tutorial_order)
                ->first(),
        ]);
    }
}
