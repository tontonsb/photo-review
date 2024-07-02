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
            return back()->with('status', __('account.link.unused'));
        }

        if ($token->user_id) {
            return back()->with(
                'status',
                $token->user_id === auth()->id() ? __('account.link.linked to you') : __('account.link.linked to other'),
            );
        }

        $token->user_id = auth()->id();
        $token->save();

        return back()->with('status', __('account.link.success'));
    }
}
