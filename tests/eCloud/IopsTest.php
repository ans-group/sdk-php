<?php

namespace Tests\eCloud;

use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use UKFast\SDK\Account\Entities\Iops;

class IopsTest extends TestCase
{
    /**
     * @test
     */
    public function get_page_of_iops()
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode([
                'data' => [
                    [
                        'id' => '22891f55-cd6b-11e9-89fb-005056a64a16',
                        'name' => 'Gold',
                        'limit' => 1500
                    ],
                    [
                        'id' => '3d12186c-cd6b-11e9-89fb-005056a64a16',
                        'name' => 'Platinum',
                        'limit' => 2000
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
        $page = $client->iops()->getPage();

        $this->assertTrue($page instanceof \UKFast\SDK\Page);
        $request = $page->getItems()[0];

        $this->assertTrue($request instanceof \UKFast\SDK\eCloud\Entities\Iops);
        $this->assertEquals('22891f55-cd6b-11e9-89fb-005056a64a16', $request->id);
        $this->assertEquals('Gold', $request->name);
        $this->assertEquals(1500, $request->limit);
    }

    /**
     * @test
     */
    public function get_iops_by_id()
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode([
                'data' => [
                    'id' => '22891f55-cd6b-11e9-89fb-005056a64a16',
                    'name' => 'Gold',
                    'limit' => 1500
                ],
                "meta" => []
            ])),
        ]);

        $handler = HandlerStack::create($mock);
        $guzzle = new Guzzle(['handler' => $handler]);

        $id = '22891f55-cd6b-11e9-89fb-005056a64a16';

        $client = new \UKFast\SDK\eCloud\Client($guzzle);
        $iopsRecord = $client->iops()->getById($id);

        $this->assertTrue($iopsRecord instanceof \UKFast\SDK\eCloud\Entities\Iops);
        $this->assertEquals($id, $iopsRecord->id);
        $this->assertEquals('Gold', $iopsRecord->name);
        $this->assertEquals(1500, $iopsRecord->limit);
    }
}
