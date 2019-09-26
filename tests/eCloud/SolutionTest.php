<?php

namespace Tests\Account;

use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class SolutionTest extends TestCase
{
    /**
     * @test
     */
    public function get_all_solutions()
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode([
                'data' => [
                    [
                        'id' => 1,
                        'name' => 'Single Site Solution',
                        'environment' => 'Hybrid',
                        'pod_id' => 5,
                    ],
                    [
                        'id' => 17106,
                        'name' => 'Pod 0 - LIVE Solution - DO NOT ALTER!',
                        'environment' => 'Hybrid',
                        'pod_id' => 20,
                    ]
                ],
                "meta" => [
                    "pagination" => [
                        "total" => 2,
                        "count" => 2,
                        "per_page" => 100,
                        "current_page" => 1,
                        "total_pages" => 1,
                        "links" => []
                    ]
                ]
            ])),
        ]);

        $handler = HandlerStack::create($mock);
        $guzzle = new Guzzle(['handler' => $handler]);

        $client = new \UKFast\SDK\eCloud\Client($guzzle);
        $solutions = $client->solutions()->getAll();

        $this->assertTrue(is_array($solutions));
        $solution = $solutions[0];

        $this->assertTrue($solution instanceof \UKFast\SDK\eCloud\Entities\Solution);
        $this->assertEquals(1, $solution->id);
        $this->assertEquals('Single Site Solution', $solution->name);
        $this->assertEquals('Hybrid', $solution->environment);
        $this->assertEquals(5, $solution->podId);
    }
}
