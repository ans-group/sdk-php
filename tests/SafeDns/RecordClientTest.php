<?php

namespace Tests\SafeDns;

use DateTime;
use Faker\Factory as Faker;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use UKFast\SDK\SafeDNS\Client as SafeDnsClient;
use UKFast\SDK\SafeDNS\Entities\Record;
use UKFast\SDK\SafeDNS\RecordClient;
use UKFast\SDK\SelfResponse;

class RecordClientTest extends TestCase
{
    /**
     * @var Faker $faker
     */
    protected $faker;

    protected function setFaker()
    {
        $this->faker = Faker::create();
    }

    /**
     * @test
     */
    public function can_get_from_safedns_client()
    {
        $this->assertInstanceOf(RecordClient::class, (new SafeDnsClient())->records());
    }

    /**
     * @test
     * @throws \Exception
     */
    public function constructs_from_response()
    {
        $this->setFaker();

        $response = [
            'id'         => $this->faker->uuid,
            'name'       => $this->faker->domainName,
            'type'       => $this->faker->word,
            'content'    => $this->faker->ipv4,
            'ttl'        => $this->faker->numberBetween(300, 86400),
            'priority'   => null,
            'updated_at' => $this->faker->dateTime('now', 'GMT')->format(DateTime::ATOM),
        ];

        $recordClient = new RecordClient;
        $record       = new Record($recordClient->apiToFriendly(
            $response,
            RecordClient::RECORD_MAP
        ));

        $this->assertEquals($response['id'], $record->id);
        $this->assertEquals($response['name'], $record->name);
        $this->assertEquals($response['type'], $record->type);
        $this->assertEquals($response['content'], $record->content);
        $this->assertEquals($response['ttl'], $record->ttl);
        $this->assertEquals($response['priority'], $record->priority);
        $this->assertInstanceOf(DateTime::class, $record->updatedAt);
        $this->assertEquals($response['updated_at'], $record->updatedAt->format(\DateTime::ATOM));
    }

    /**
     * @test
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function creates_and_gets_ssl_correctly()
    {
        $this->setFaker();
        
        $domainName = $this->faker->domainName;
        $apiData    = [
            'id'         => $this->faker->uuid,
            'name'       => $this->faker->domainWord . '.' . $domainName,
            'type'       => $this->faker->word,
            'content'    => $this->faker->ipv4,
            'ttl'        => $this->faker->numberBetween(300, 86400),
            'priority'   => null,
            'updated_at' => $this->faker->dateTime('now', 'GMT')->format(DateTime::ATOM),
        ];

        $mockHandler = new MockHandler([
            new Response(201, [], json_encode([
                'data' => [
                    'id' => $apiData['id'],
                ],
                'meta' => [
                    'location' => 'http://localhost/safedns/v1/zones/' . $domainName . '/' . $apiData['id'],
                ],
            ])),
            new Response(200, [], json_encode([
                'data' => $apiData,
                'meta' => [],
            ])),
        ]);

        $httpClient     = new GuzzleClient(['handler' => HandlerStack::create($mockHandler)]);
        $client         = new RecordClient($httpClient);

        $inputRecord       = new Record($client->apiToFriendly($apiData, RecordClient::RECORD_MAP));
        $inputRecord->zone = $domainName;

        $createResponse = $client->create($inputRecord);

        $this->assertInstanceOf(SelfResponse::class, $createResponse);

        $this->assertInstanceOf(Record::class, $createResponse->get());
    }

    /**
     * @test
     */
    public function updates_only_name_and_content_when_ttl_and_priority_are_not_set()
    {
        $this->setFaker();

        $requests = [];
        $client   = $this->updateClient($requests);

        $record = new Record([
            'id'      => $this->faker->randomNumber(),
            'zone'    => $this->faker->domainName,
            'name'    => $this->faker->domainName,
            'content' => $this->faker->ipv4,
        ]);

        $this->assertTrue($client->update($record));

        $this->assertCount(1, $requests);
        $this->assertEquals('PATCH', $requests[0]['request']->getMethod());
        $this->assertStringEndsWith(
            'v1/zones/' . $record->zone . '/records/' . $record->id,
            $requests[0]['request']->getUri()->getPath()
        );
        $this->assertEquals(
            ['name' => $record->name, 'content' => $record->content],
            json_decode((string) $requests[0]['request']->getBody(), true)
        );
    }

    /**
     * @test
     */
    public function updates_ttl_and_priority_when_set()
    {
        $this->setFaker();

        $requests = [];
        $client   = $this->updateClient($requests);

        $record = new Record([
            'id'       => $this->faker->randomNumber(),
            'zone'     => $this->faker->domainName,
            'name'     => $this->faker->domainName,
            'content'  => 'mail.' . $this->faker->domainName,
            'ttl'      => '300',
            'priority' => 20,
        ]);

        $this->assertTrue($client->update($record));

        $this->assertSame(
            ['name' => $record->name, 'content' => $record->content, 'ttl' => 300, 'priority' => 20],
            json_decode((string) $requests[0]['request']->getBody(), true)
        );
    }

    /**
     * A RecordClient whose requests are recorded into $requests and
     * answered with a successful update response.
     *
     * @param array $requests
     * @return RecordClient
     */
    protected function updateClient(array &$requests)
    {
        $mockHandler = new MockHandler([
            new Response(200, [], json_encode([
                'data' => ['id' => 1],
                'meta' => ['location' => 'http://localhost/safedns/v1/zones/example.com/records/1'],
            ])),
        ]);

        $stack = HandlerStack::create($mockHandler);
        $stack->push(Middleware::history($requests));

        return new RecordClient(new GuzzleClient(['handler' => $stack]));
    }
}
