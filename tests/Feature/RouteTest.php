<?php

namespace Tests\Feature;

use App\Models\Conclusion;
use App\Models\Review;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class RouteTest extends TestCase
{
    use DatabaseTransactions;

    public function testRoutesAreAlive(): void
    {
        $this->get('/')->assertOk();
        $this->get('reviewables')->assertOk();
        $this->get('reviewables/somephoto')->assertOk();
        $this->get('reviewers')->assertOk();
        $this->get('reviews')->assertOk();
    }

    public function testSubmissionSomewhatWorks(): void
    {
        $path = 'thetestphoto.test';
        $duration = 134543;

        $this->post('/', [
            'filepath' => $path,
            'conclusion' => 'suspect',
            'review' => 'my review',
            'problem' => null,
            'reviewing_duration_ms' => $duration,
        ])->assertRedirectToRoute('reviewables.random');

        $this->post('/', [
            'filepath' => $path,
            'conclusion' => 'suspect',
            'review' => null,
            'problem' => 'a problem',
            'reviewing_duration_ms' => $duration,
        ])->assertRedirectToRoute('reviewables.random');

        $this->post('/', [
            'filepath' => $path,
            'conclusion' => 'skip',
            'review' => null,
            'problem' => null,
            'reviewing_duration_ms' => $duration,
        ])->assertRedirectToRoute('reviewables.random');

        $this->post('/', [
            'filepath' => $path,
            'conclusion' => 'ok',
            'review' => 'still left a review',
            'problem' => null,
            'reviewing_duration_ms' => $duration,
        ])->assertRedirectToRoute('reviewables.random');

        // Check that the submitted data got recorded
        $reviews = Review::where('file', $path)->get();

        $suspectReviews = $reviews->where('conclusion', Conclusion::suspect);
        $skipReviews = $reviews->where('conclusion', Conclusion::skip);
        $okReviews = $reviews->where('conclusion', Conclusion::ok);

        $this->assertCount(2, $suspectReviews);
        $this->assertCount(1, $suspectReviews->whereNotNull('problem'));
        $this->assertCount(1, $suspectReviews->whereNotNull('review'));
        $this->assertEquals($duration, $suspectReviews->first()->reviewing_duration_ms);

        $this->assertCount(1, $skipReviews);
        $this->assertNull($skipReviews->first()->review);
        $this->assertNull($skipReviews->first()->problem);
        $this->assertEquals($duration, $skipReviews->first()->reviewing_duration_ms);

        $this->assertCount(1, $okReviews);
        $this->assertNotNull($okReviews->first()->reviewer_id);
        $this->assertNotNull($okReviews->first()->review);
        $this->assertNull($okReviews->first()->problem);
        $this->assertEquals($duration, $okReviews->first()->reviewing_duration_ms);
    }
}
