<?php

namespace Tests\Pss;

use PHPUnit\Framework\TestCase;
use UKFast\SDK\PSS\Entities\Request;

class RequestTest extends TestCase
{
    /**
     * @test
     */
    public function identifies_completed_requests_as_complete()
    {
        $request = new Request;
        $request->status = 'Completed';

        $this->assertTrue($request->isCompleted());
    }

    /**
     * @test
     */
    public function identifies_replied_and_completed_requests_as_complete()
    {
        $request = new Request;
        $request->status = 'Replied and Completed';

        $this->assertTrue($request->isCompleted());
    }

    /**
     * @test
     */
    public function identifies_other_statuses_as_incomplete()
    {
        $request = new Request;
        $request->status = 'submitted';

        $this->assertFalse($request->isCompleted());
    }
}
