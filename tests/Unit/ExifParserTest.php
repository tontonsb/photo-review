<?php

namespace Tests\Unit;

use App\Services\ParseExif;
use PHPUnit\Framework\TestCase;

class ExifParserTest extends TestCase
{
    public function testGpsExtraction(): void
    {
        $exif = [
            'GPSLatitudeRef' => 'N',
            'GPSLatitude' => [
                '56/1',
                '54/1',
                '389947/10000',
            ],
            'GPSLongitudeRef' => 'E',
            'GPSLongitude' => [
                '23/1',
                '33/1',
                '406665/10000',
            ],
        ];

        $location = ParseExif::getLocation($exif);

        $this->assertEqualsWithDelta($location['lat'], 56.910832, 10E-6);
        $this->assertEqualsWithDelta($location['lon'], 23.561296, 10E-6);
    }
}
