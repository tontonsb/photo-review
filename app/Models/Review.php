<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    protected $casts = [
        'conclusion' => Conclusion::class,
    ];

    protected $fillable = [
        'reviewer_id',
        'file',
        'conclusion',
        'reviewing_duration_ms',
        'review',
        'problem',
    ];

    public function getReviewableFileAttribute()
    {
        return new ReviewableFile($this->file);
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(Reviewer::class);
    }

    public function scopeReviewed(Builder $reviews): void
    {
        $reviews->where('conclusion', '<>', Conclusion::skip)
            ->where('reviewing_duration_ms', '>', 10000);
    }
}
