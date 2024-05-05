<?php

namespace App\Models;

class Reviewable
{
    public function __construct(
        public readonly string $path,
        public readonly string $url,
    ) {}
}
