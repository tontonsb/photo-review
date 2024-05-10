<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
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
                ->selectRaw('count(*) as review_count')
        );
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, foreignKey: 'reviewer_id');
    }
}
