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

    // Mākslīgais intelekts™ par pārskatītām uzskatīs bildes
    public function scopeReviewed(Builder $reviews): void
    {
        // Kuras nav skipotas
        $reviews->where('conclusion', '<>', Conclusion::skip)
            // un kuras ir skatītas ilgāk par 6 sekundēm
            ->where('reviewing_duration_ms', '>', 6000);
    }
}
