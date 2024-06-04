<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Reviewable extends Model
{
    protected $primaryKey = 'path';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $casts = [
        'metadata' => 'array',
    ];

    protected ReviewableFile $file;

    public function getFileAttribute(): ReviewableFile
    {
        return $this->file ??= new ReviewableFile($this->path);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'file', 'path');
    }

    public function getDataAttribute(): array
    {
        return $this->metadata ?? $this->file?->getData();
    }

    public function scopeTutorial(Builder $reviews): void
    {
        $reviews->whereNotNull('tutorial_order');
    }

    public function scopeNonTutorial(Builder $reviews): void
    {
        $reviews->where('path', 'not like', 'tutorial/%');
    }
}
