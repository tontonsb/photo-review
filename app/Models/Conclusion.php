<?php

namespace App\Models;

enum Conclusion: string
{
    case ok = 'ok';
    case suspect = 'suspect';
    case skip = 'skip';

    public function title(): string
    {
        return $this->icon().' '.__('enums.'.static::class.'.'.$this->name);
    }

    public function icon(): string
    {
        return match($this) {
            static::ok => '✔️',
            static::suspect => '⁉️',
            static::skip => '🔄️',
        };
    }
}
