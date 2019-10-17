<?php

namespace Tests\eCloud;

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;

use \UKFast\SDK\eCloud\Entities\Datastore;

class DatastoreCreateTest extends TestCase
{
    /**
     * @test
     */
    public function create_datastore()
    {
        $mock = new MockHandler([
            new Response(202, [], json_encode([
                "data" => [
                    "id" => 2237
                ],
                "meta" => []
            ])),
        ]);

        $handler = HandlerStack::create($mock);
        $guzzle = new Guzzle(['handler' => $handler]);
        $client = new \UKFast\SDK\eCloud\Client($guzzle);

        $datastore = new Datastore(
            [
                'name' => 'Test Datastore',
                'solutionId' => 123,
                'capacity' => 500
            ]
        );

        $datastore = $client->datastores()->create($datastore);

        $this->assertTrue($datastore instanceof Datastore);
        $this->assertEquals(2237, $datastore->id);
        $this->assertEquals('Test Datastore', $datastore->name);
        $this->assertEquals('Queued', $datastore->status);
        $this->assertEquals(500, $datastore->capacity);
        $this->assertEquals(123, $datastore->solutionId);
    }
}
