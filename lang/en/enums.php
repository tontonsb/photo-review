<?php

use App\Models\Conclusion;
use App\Models\Status;

return [
    Conclusion::class => [
        'ok' => 'OK',
        'suspect' => 'Suspicious',
        'skip' => 'Skipped',
    ],

    Status::class => [
        'ok' => 'OK',
        'suspect' => 'Important',
        'checkable' => 'Needs visiting',
        'redo' => 'Retake photo',
        'unclear' => 'Unlcear',
    ],
];
