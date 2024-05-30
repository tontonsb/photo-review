<?php

namespace App\Models;

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
}
