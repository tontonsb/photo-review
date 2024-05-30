<?php

namespace App\Models;

enum Status: string
{
    case ok = 'ok';
    case suspect = 'suspect';
    case checkable = 'checkable';
    case redo = 'redo';

    public function lv(): string
    {
        return match($this) {
            static::ok => '✅ OK',
            static::suspect => '‼️ Svarīgi',
            static::checkable => '🚶 Jāpārbauda klātienē',
            static::redo => '📷 Jāpārbildē',
        };
    }
}
