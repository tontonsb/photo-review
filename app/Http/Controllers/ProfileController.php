<?php

namespace App\Http\Controllers;

use App\Models\Reviewer;
use App\Models\ReviewerToken;
use Illuminate\Http\Request;

class ProfileController
{
    public function me()
    {
        $reviewerIdentities = Reviewer::whereHas(
            'token',
            fn($t) => $t->where('user_id', auth()-> id()),
        )->get();

        $reviewerIdentities->loadCount([
            'reviews',
            'reviewsWithInfo',
            'reviewsWithFeedback',
        ]);

        return view('me', [
            'reviewerIdentities' => $reviewerIdentities,
        ]);
    }

    public function bind(Request $request)
    {
        $token = ReviewerToken::where('transfer_token', $request->code)->first();

        if (!$token) {
            return back()->with('status', 'Norādītais kods neatbilst nevienam pārskatītājam.');
        }

        if ($token->user_id) {
            return back()->with('status', 'Šis progress jau ir piesaistīts cita lietotāja kontam.');
        }

        $token->user_id = auth()->id();
        $token->save();

        return back()->with('status', 'Pārskatīšanas progress piesaistīts kontam!');
    }
}
