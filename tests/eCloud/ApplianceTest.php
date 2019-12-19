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
            'logo_uri' => 'https://images.ukfast.co.uk/300x300_white.jpg',
            'description' => 'WordPress is open source',
            'documentation_uri' => 'https://en-gb.wordpress.org',
            'publisher' => 'UKFast',
            'created_at' => '0000-00-00T00:00:00+00:00',
        ];
        $mock = new MockHandler([new Response(200, [], json_encode(['data' => $data, 'meta' => []]))]);
        $client = new \UKFast\SDK\eCloud\Client(new Guzzle(['handler' => HandlerStack::create($mock)]));
        $appliance = $client->appliances()->getById($data['id']);
        $this->assertTrue($appliance instanceof \UKFast\SDK\eCloud\Entities\Appliance);
        foreach (array_keys($data) as $key) {
            $modelKey = lcfirst(str_replace('_', '', ucwords($key, '_')));
            $this->assertEquals($data[$key], $appliance->$modelKey);
        }
    }

    public function testGetApplianceVersion()
    {
        $data = [
            'id' => 'ccd66630-a25e-4281-9042-e83ff71c371e',
            'appliance_id' => '2bb38535-9f11-49b0-b6dd-37e405b57cd8',
            'description' => 'description',
            'script_template' => 'cat /var/www/html/wp-config.php',
            'created_at' => '2019-03-14T11:41:18+00:00',
            'updated_at' => '2019-03-14T11:41:18+00:00',
        ];
        $mock = new MockHandler([new Response(200, [], json_encode(['data' => $data, 'meta' => []]))]);
        $client = new \UKFast\SDK\eCloud\Client(new Guzzle(['handler' => HandlerStack::create($mock)]));
        $applianceVersion = $client->appliances()->getVersion($data['appliance_id']);
        $this->assertTrue($applianceVersion instanceof \UKFast\SDK\eCloud\Entities\ApplianceVersion);
        foreach (array_keys($data) as $key) {
            $modelKey = lcfirst(str_replace('_', '', ucwords($key, '_')));
            $this->assertEquals($data[$key], $applianceVersion->$modelKey);
        }
    }

    public function testGetApplianceData()
    {
        $data = [
            'key' => 'key',
            'value' => 'value',
        ];
        $mock = new MockHandler([new Response(200, [], json_encode(['data' => $data, 'meta' => []]))]);
        $client = new \UKFast\SDK\eCloud\Client(new Guzzle(['handler' => HandlerStack::create($mock)]));
        $applianceVersionData = $client->appliances()->getData(null);
        $this->assertTrue($applianceVersionData instanceof \UKFast\SDK\eCloud\Entities\Appliance\Version\Data);
        foreach (array_keys($data) as $key) {
            $modelKey = lcfirst(str_replace('_', '', ucwords($key, '_')));
            $this->assertEquals($data[$key], $applianceVersionData->$modelKey);
        }
    }
}
