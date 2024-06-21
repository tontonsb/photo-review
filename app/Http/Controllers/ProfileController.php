<?php

namespace App\Http\Controllers;

use App\Models\Conclusion;
use App\Models\Reviewer;
use App\Models\ReviewerToken;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;

class ProfileController
{
    public function me()
    {
        $user = auth()->user();

        $reviewerIdentities = Reviewer::whereHas(
            'token',
            fn($t) => $t->where('user_id', $user->id),
        )->get();

        $reviewerIdentities->loadCount([
            'reviews',
            'reviewsWithInfo',
            'reviewsWithFeedback',
        ]);

        $reviews = $user->reviews;

        return view('me', [
            'reviewerIdentities' => $reviewerIdentities,
            'reviews' => $reviews,
            'reviewCount' => $reviews->count(),
            'reviewedCount' => $reviews->where('conclusion', '!=', Conclusion::skip)->count(),
            'timeSpent' => CarbonInterval::milliseconds($reviews->sum('reviewing_duration_ms'))->cascade()->forHumans(['short' => true]),
        ]);
    }

    public function bind(Request $request)
    {
        $token = ReviewerToken::where('transfer_token', $request->code)->first();

        if (!$token) {
            return back()->with('status', 'Norādītais kods neatbilst nevienam pārskatītājam.');
        }

        if ($token->user_id) {
            return back()->with(
                'status',
                'Šis progress jau ir piesaistīts '.($token->user_id === auth()->id() ? 'tavam' : 'cita lietotāja').' kontam.',
            );
        }

        $token->user_id = auth()->id();
        $token->save();

        return back()->with('status', 'Pārskatīšanas progress piesaistīts kontam!');
    }
}
