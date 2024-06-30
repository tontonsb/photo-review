<?php

namespace App\Models;

enum Status: string
{
    case ok = 'ok';
    case suspect = 'suspect';
    case checkable = 'checkable';
    case redo = 'redo';
    case unclear = 'unclear';

    public function title(): string
    {
        return $this->icon().' '.__('enums.'.static::class.'.'.$this->name);
    }

    public function icon(): string
    {
        return match($this) {
            static::ok => '✅',
            static::suspect => '🆘',
            static::checkable => '🚶',
            static::redo => '📷',
            static::unclear => '❓',
        };
    }
}
