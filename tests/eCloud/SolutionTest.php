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
    public function get_datastores()
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode([
                'data' => [
                    [
                        'id' => 1,
                        'name' => 'Datastore 1',
                        'status' => 'Completed',
                        'capacity' => 700,
                        'allocated' => null,
                        'available' => null,
                        'solution_id' => 1,
                        'site_id' => null,
                    ],
                    [
                        'id' => 1,
                        'name' => 'Datastore 2',
                        'status' => 'Expanding',
                        'capacity' => 500,
                        'allocated' => null,
                        'available' => null,
                        'solution_id' => 1,
                        'site_id' => null,
                    ],
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
        $solutionId = 1;
        $page = $client->solutions()->getDatastores($solutionId);

        $this->assertTrue($page instanceof \UKFast\SDK\Page);
        $request = $page->getItems()[0];

        $this->assertTrue($request instanceof \UKFast\SDK\eCloud\Entities\Datastore);
        $this->assertEquals(1, $request->id);
        $this->assertEquals('Datastore 1', $request->name);
        $this->assertEquals('Completed', $request->status);
        $this->assertEquals(700, $request->capacity);
        $this->assertNull($request->allocated);
        $this->assertNull($request->available);
        $this->assertEquals(1, $request->solutionId);
        $this->assertNull($request->siteId);
    }
}
