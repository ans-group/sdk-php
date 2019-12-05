<?php

namespace Tests\eCloud;

use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class PodTest extends TestCase
{
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
