<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    protected $fillable = [
        'reviewer_id',
        'file',
        'review',
        'problem',
    ];

    public function getReviewableAttribute()
    {
        return new Reviewable($this->file);
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(Reviewer::class);
    }
}
