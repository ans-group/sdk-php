<?php
namespace Tests\eCloud;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use \UKFast\SDK\eCloud\Entities\Datastore;

class DatastoreExpandTest extends TestCase
{
    /**
     * @test
     */
    public function expand_datastore()
    {
        $mock = new MockHandler([
            new Response(202),
        ]);
        $handler = HandlerStack::create($mock);
        $guzzle = new Guzzle(['handler' => $handler]);
        $client = new \UKFast\SDK\eCloud\Client($guzzle);

        $datastore = new Datastore(
            [
                'id' => 123,
                'capacity' => 500
            ]
        );
        $response = $client->datastores()->expand($datastore);

        $this->assertTrue($response);
    }
}
