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
                        'name' => 'Solution 1',
                        'environment' => 'Hybrid',
                        'pod_id' => 1,
                    ],
                    [
                        'id' => 2,
                        'name' => 'Solution 2',
                        'environment' => 'Hybrid',
                        'pod_id' => 2,
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
        $this->assertEquals('Solution 1', $solution->name);
        $this->assertEquals('Hybrid', $solution->environment);
        $this->assertEquals(1, $solution->podId);
    }
}
