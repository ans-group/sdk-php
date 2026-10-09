<?php

namespace Tests\eCloud;

use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use UKFast\SDK\eCloud\Entities\Instance;

class InstanceTest extends TestCase
{
    public function testCreateSendsIpAddress()
    {
        $container = [];
        $created = [
            'data' => ['id' => 'i-12345678'],
            'meta' => ['location' => 'https://api.example.com/ecloud/v2/instances/i-12345678'],
        ];
        $mock = new MockHandler([new Response(202, [], json_encode($created))]);
        $stack = HandlerStack::create($mock);
        $stack->push(Middleware::history($container));
        $client = new \UKFast\SDK\eCloud\Client(new Guzzle(['handler' => $stack]));

        $client->instances()->createEntity(new Instance(['name' => 'web', 'ipAddress' => '10.0.0.10']));

        $this->assertCount(1, $container);
        $body = (string) $container[0]['request']->getBody();
        $this->assertNotFalse(strpos($body, '"ip_address":"10.0.0.10"'));
        $this->assertFalse(strpos($body, 'ipAddress'));
        $this->assertFalse(strpos($body, 'custom_ip_address'));
    }

    public function testLoadedInstanceWithoutIpAddressIsNull()
    {
        $data = ['id' => 'i-12345678', 'name' => 'web'];
        $mock = new MockHandler([new Response(200, [], json_encode(['data' => $data, 'meta' => []]))]);
        $client = new \UKFast\SDK\eCloud\Client(new Guzzle(['handler' => HandlerStack::create($mock)]));

        $instance = $client->instances()->getById('i-12345678');

        $this->assertNull($instance->ipAddress);
    }
}
