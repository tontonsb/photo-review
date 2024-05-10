<?php

namespace App\Models;

enum Conclusion: string
{
    case ok = 'ok';
    case suspect = 'suspect';
    case skip = 'skip';

    public function lv(): string
    {
        return match($this) {
            static::ok => 'OK',
            static::suspect => 'Aizdomīga',
            static::skip => 'Izlaista',
        };
    }
}
