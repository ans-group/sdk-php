<?php

namespace Tests\Account;

use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class HostTest extends TestCase
{
    /**
     * @test
     */
    public function get_page_of_hosts()
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode([
                'data' => [
                    [
                        'id' => 1,
                        "solution_id" => 1,
                        "pod_id" => 1,
                        "name" => '2 x Oct Core 2.1Ghz (E5-2620 v4) 128GB',
                        "cpu" => [
                            'qty' => 2,
                            'cores' => 8,
                            'speed' =>  '2.1Ghz',
                        ],
                        "ram" => [
                            'capacity' => 128
                        ]
                    ],
                    [
                        'id' => 1,
                        "solution_id" => 2,
                        "pod_id" => 2,
                        "name" => '3 x Quad Core 2.1Ghz (E5-2620 v4) 128GB',
                        "cpu" => [
                            'qty' => 2,
                            'cores' => 8,
                            'speed' =>  '2.1Ghz',
                        ],
                        "ram" => [
                            'capacity' => 128
                        ]
                    ]
                ],
                "meta" => [
                    "pagination" => [
                        "total" => 40,
                        "count" => 40,
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
        $page = $client->hosts()->getPage();

        $this->assertTrue($page instanceof \UKFast\SDK\Page);
        $request = $page->getItems()[0];

        $this->assertTrue($request instanceof \UKFast\SDK\eCloud\Entities\Host);

        $this->assertEquals(1, $request->id);

        $this->assertEquals(1, $request->solutionId);
        $this->assertEquals(1, $request->podId);
        $this->assertEquals('2 x Oct Core 2.1Ghz (E5-2620 v4) 128GB', $request->name);

        $this->assertEquals((object )[
            'qty' => 2,
            'cores' => 8,
            'speed' =>  '2.1Ghz',
        ], $request->cpu);

        $this->assertEquals((object) [
            'capacity' => 128
        ], $request->ram);
    }

    /**
     * @test
     */
    public function get_host_by_id()
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode([
                'data' => [
                    'id' => 1,
                    "solution_id" => 1,
                    "pod_id" => 1,
                    "name" => '2 x Oct Core 2.1Ghz (E5-2620 v4) 128GB',
                    "cpu" => [
                        'qty' => 2,
                        'cores' => 8,
                        'speed' =>  '2.1Ghz',
                    ],
                    "ram" => [
                        'capacity' => 128
                    ]
                ],
                "meta" => []
            ])),
        ]);

        $handler = HandlerStack::create($mock);
        $guzzle = new Guzzle(['handler' => $handler]);

        $id = 1;

        $client = new \UKFast\SDK\eCloud\Client($guzzle);
        $host = $client->hosts()->getById($id);

        $this->assertTrue($host instanceof \UKFast\SDK\eCloud\Entities\Host);

        $this->assertEquals(1, $host->id);

        $this->assertEquals(1, $host->solutionId);
        $this->assertEquals(1, $host->podId);
        $this->assertEquals('2 x Oct Core 2.1Ghz (E5-2620 v4) 128GB', $host->name);

        $this->assertEquals((object )[
            'qty' => 2,
            'cores' => 8,
            'speed' =>  '2.1Ghz',
        ], $host->cpu);

        $this->assertEquals((object) [
            'capacity' => 128
        ], $host->ram);
    }
}
