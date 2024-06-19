<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Reviewer extends Model
{
    protected $table = 'reviews';
    protected $primaryKey = 'reviewer_id';
    protected $keyType = 'string';

    protected static function booted(): void
    {
        static::addGlobalScope('reviewers', fn(Builder $builder) =>
            $builder->groupBy('reviewer_id')
                ->select('reviewer_id')
        );
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, foreignKey: 'reviewer_id');
    }

    public function reviewsWithInfo(): HasMany
    {
        return $this->reviews()->withInfo();
    }

    public function reviewsWithFeedback(): HasMany
    {
        return $this->reviews()->whereNotNull('status');
    }

    public function token(): BelongsTo
    {
        return $this->belongsTo(ReviewerToken::class, 'reviewer_id', 'reviewer_id');
    }
}
