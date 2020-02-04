<?php

namespace Tests\eCloud;

use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class PodTest extends TestCase
{
    /**
     * @test
     */
    public function get_pod()
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode([
                'data' => [
                    'id' => 1,
                    'name' => 'RnD Cloud',
                    'services' => [
                        'public' => true,
                        'burst' => true,
                        'appliances' => true,
                        'gpu' => true,
                    ]
                ],
                "meta" => [
                    "pagination" => [
                        "total" => 1,
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
        $pod = $client->pods()->getById(1);

        $this->assertTrue($pod instanceof \UKFast\SDK\eCloud\Entities\Pod);

        $this->assertEquals(1, $pod->id);
        $this->assertEquals('RnD Cloud', $pod->name);
        $this->assertEquals((object) [
            'public' => true,
            'burst' => true,
            'appliances' => true,
            'gpu' => true,
        ], $pod->services);
    }

    /**
     * @test
     */
    public function testGetPodAppliances()
    {
        $data = [[
            'id' => 1,
            'name' => 'Appliance',
            'description' => 'Appliance Description',
        ]];

        $mock = new MockHandler([new Response(200, [], json_encode(['data' => $data, 'meta' => []]))]);
        $client = new \UKFast\SDK\eCloud\Client(new Guzzle(['handler' => HandlerStack::create($mock)]));

        $appliance = $client->pods()->getAppliances(123)->getItems()[0];
        $this->assertTrue($appliance instanceof \UKFast\SDK\eCloud\Entities\Appliance);
    }
}
