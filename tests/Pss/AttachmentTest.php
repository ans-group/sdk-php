<?php

namespace Tests\Pss;

use PHPUnit\Framework\TestCase;
use UKFast\PSS\Entities\Attachment;

class AttachmentTest extends TestCase
{
    /**
     * @test
     */
    public function constructs_from_response()
    {
        $attachment = new Attachment((object)[
            'name' => 'test_file.txt',
        ]);

        $this->assertEquals('test_file.txt', $attachment->name);
    }
}
