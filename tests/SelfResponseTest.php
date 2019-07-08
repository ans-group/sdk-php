<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use UKFast\SDK\SelfResponse;

class SelfResponseTest extends TestCase
{
    /**
     * @test
     */
    public function parses_data_and_meta()
    {
        $response = (object) [
            'data' => (object) [
                'id' => 23
            ],
            'meta' => (object) [
                'location' => 'https://example.com/23'
            ],
        ];

        $selfResponse = new SelfResponse($response);

        $this->assertEquals(23, $selfResponse->getId());
        $this->assertEquals('https://example.com/23', $selfResponse->getLocation());
    }
}
