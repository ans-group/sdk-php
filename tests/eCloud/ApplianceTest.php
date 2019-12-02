<?php

namespace Tests\eCloud;

use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class ApplianceTest extends TestCase
{
    public function testGetAppliance()
    {
        $data = [
            'id' => 1,
            'name' => 'Wordpress',
            'logoUri' => 'https://images.ukfast.co.uk/300x300_white.jpg',
            'description' => 'WordPress is open source',
            'documentationUri' => 'https://en-gb.wordpress.org',
            'publisher' => 'UKFast',
            'createdAt' => '0000-00-00T00:00:00+00:00',
        ];
        $mock = new MockHandler([new Response(200, [], json_encode(['data' => $data, 'meta' => []]))]);
        $client = new \UKFast\SDK\eCloud\Client(new Guzzle(['handler' => HandlerStack::create($mock)]));
        $appliance = $client->appliance()->getById($data['id']);
        $this->assertTrue($appliance instanceof \UKFast\SDK\eCloud\Entities\Appliance);
        foreach (array_keys($data) as $key) {
            $this->assertEquals($data[$key], $appliance->$key);
        }
    }

    public function testGetApplianceVersion()
    {
        $data = [
            'id' => 'ccd66630-a25e-4281-9042-e83ff71c371e',
            'applianceId' => '2bb38535-9f11-49b0-b6dd-37e405b57cd8',
            'version' => 2,
            'scriptTemplate' => 'cat /var/www/html/wp-config.php',
            'vm_template' => 'centos7-wordpress-v1.0.0',
            'active' => true,
            'createdAt' => '2019-03-14T11:41:18+00:00',
            'updatedAt' => '2019-03-14T11:41:18+00:00',
        ];
        $mock = new MockHandler([new Response(200, [], json_encode(['data' => $data, 'meta' => []]))]);
        $client = new \UKFast\SDK\eCloud\Client(new Guzzle(['handler' => HandlerStack::create($mock)]));
        $applianceVersion = $client->appliance()->getVersion($data['applianceId']);
        $this->assertTrue($applianceVersion instanceof \UKFast\SDK\eCloud\Entities\ApplianceVersion);
        foreach (array_keys($data) as $key) {
            $this->assertEquals($data[$key], $applianceVersion->$key);
        }
    }

    public function testGetApplianceData()
    {
        $data = [
            'applianceId' => 1,
            'key' => 'key',
            'value' => 'value',
        ];
        $mock = new MockHandler([new Response(200, [], json_encode(['data' => $data, 'meta' => []]))]);
        $client = new \UKFast\SDK\eCloud\Client(new Guzzle(['handler' => HandlerStack::create($mock)]));
        $applianceVersionData = $client->appliance()->getData($data['applianceId']);
        $this->assertTrue($applianceVersionData instanceof \UKFast\SDK\eCloud\Entities\Appliance\Version\Data);
        foreach (array_keys($data) as $key) {
            $this->assertEquals($data[$key], $applianceVersionData->$key);
        }
    }
}
