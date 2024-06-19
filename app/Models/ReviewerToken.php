<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class ReviewerToken extends Model
{
    protected $primaryKey = 'reviewer_id';
    protected $keyType = 'string';

    public static function getOrRegister(string $reviewerToken): static
    {
        if ($existing = static::find($reviewerToken))
            return $existing;

        return static::register($reviewerToken);
    }

    protected static function register(string $reviewerToken): static
    {
        return static::forceCreate([
            'reviewer_id' => $reviewerToken,
            'transfer_token' => (string) Str::ulid(),
        ]);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(Reviewer::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'reviewer_id', 'reviewer_id');
    }
}
