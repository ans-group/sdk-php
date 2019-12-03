<?php

namespace Tests\eCloud;

use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class ApplianceVersionDataTest extends TestCase
{
    public function testGetApplianceVersionData()
    {
        $data = [
            'key' => 'key',
            'value' => 'value',
        ];
        $mock = new MockHandler([new Response(200, [], json_encode(['data' => $data, 'meta' => []]))]);
        $client = new \UKFast\SDK\eCloud\Client(new Guzzle(['handler' => HandlerStack::create($mock)]));
        $applianceVersionData = $client->applianceVersion()->getDataByKey(null, $data['key']);
        $this->assertTrue($applianceVersionData instanceof \UKFast\SDK\eCloud\Entities\Appliance\Version\Data);
        foreach (array_keys($data) as $key) {
            $modelKey = lcfirst(str_replace('_', '', ucwords($key, '_')));
            $this->assertEquals($data[$key], $applianceVersionData->$modelKey);
        }
    }
}
