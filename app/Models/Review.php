<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Review extends Model
{
    protected $casts = [
        'conclusion' => Conclusion::class,
        'coordinates' => 'array',
        'status' => Status::class,
    ];

    protected $fillable = [
        'reviewer_id',
        'file',
        'conclusion',
        'reviewing_duration_ms',
        'review',
        'problem',
        'coordinates',
    ];

    public function getReviewableFileAttribute()
    {
        return new ReviewableFile($this->file);
    }

    public function getDurationAttribute()
    {
        return number_format($this->reviewing_duration_ms / 1000, 1).' s';
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(Reviewer::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
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
