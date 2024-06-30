<?php

use App\Models\Conclusion;
use App\Models\Status;

return [
    Conclusion::class => [
        'ok' => 'OK',
        'suspect' => 'Aizdomīga',
        'skip' => 'Izlaista',
    ],

    Status::class => [
        'ok' => 'OK',
        'suspect' => 'Svarīgi',
        'checkable' => 'Jāpārbauda klātienē',
        'redo' => 'Jāpārbildē',
        'unclear' => 'Neskaidrs',
    ],
];
