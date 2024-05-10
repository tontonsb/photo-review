<?php

namespace App\Models;

enum Conclusion: string
{
    case ok = 'ok';
    case suspect = 'suspect';
    case skip = 'skip';
}
