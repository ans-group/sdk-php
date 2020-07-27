<?php

namespace Tests\DDoSX;

use DateTime;
use Faker\Factory as Faker;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use UKFast\SDK\DDoSX\Client as DdosxClient;
use UKFast\SDK\DDoSX\Entities\Ssl;
use UKFast\SDK\DDoSX\SslClient;
use UKFast\SDK\SelfResponse;

class SslClientTest extends TestCase
{
    /**
     * @var Faker $faker
     */
    protected $faker;

    protected function setUp()
    {
        parent::setUp();

        $this->faker = Faker::create();
    }

    /**
     * @test
     */
    public function can_get_from_ddosx_client()
    {
        $this->assertInstanceOf(SslClient::class, (new DdosxClient())->ssls());
    }

    /**
     * @test
     * @throws \Exception
     */
    public function constructs_from_response()
    {
        $response = [
            'id'            => $this->faker->uuid,
            'ukfast_ssl_id' => $this->faker->randomDigit,
            'domains'       => [
                $this->faker->domainName,
                $this->faker->domainName,
            ],
            'friendly_name' => $this->faker->word,
            'expires_at'    => $this->faker->dateTimeBetween('+1 day', '+825 days')->format(DateTime::ATOM),
        ];

        $sslClient = new SslClient;

        $ssl = new Ssl($sslClient->apiToFriendly($response, SslClient::SSL_MAP));

        $this->assertEquals($response['id'], $ssl->id);
        $this->assertEquals($response['ukfast_ssl_id'], $ssl->ukfastSslId);
        $this->assertEquals($response['domains'], $ssl->domains);
        $this->assertEquals($response['friendly_name'], $ssl->friendlyName);
        $this->assertInstanceOf(DateTime::class, $ssl->expiresAt);
        $this->assertEquals($response['expires_at'], $ssl->expiresAt->format(\DateTime::ATOM));
    }

    /**
     * @test
     * @throws \Exception
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function gets_ssl_page()
    {
        $mockHandler = new MockHandler([
            new Response(200, [], json_encode([
                'data' => [
                    [
                        'id'            => $this->faker->uuid,
                        'ukfast_ssl_id' => $this->faker->randomDigit,
                        'domains'       => [
                            $this->faker->domainName,
                            $this->faker->domainName,
                        ],
                        'friendly_name' => $this->faker->word,
                        'expires_at'    => $this->faker->dateTimeBetween('+1 day', '+825 days')->format(DateTime::ATOM),
                    ],
                    [
                        'id'            => $this->faker->uuid,
                        'ukfast_ssl_id' => $this->faker->randomDigit,
                        'domains'       => [
                            $this->faker->domainName,
                            $this->faker->domainName,
                        ],
                        'friendly_name' => $this->faker->word,
                        'expires_at'    => $this->faker->dateTimeBetween('+1 day', '+825 days')->format(DateTime::ATOM),
                    ],
                ],
                'meta' => [
                    'pagination' => [
                        'total'       => 2,
                        'per_page'    => 2,
                        'total_pages' => 1,
                        'links'       => [
                            'next'     => 'http://example.com/next',
                            'previous' => 'http://example.com/previous',
                            'first'    => 'http://example.com/first',
                            'last'     => 'http://example.com/last',
                        ]
                    ]
                ]
            ])),
        ]);

        $httpClient = new GuzzleClient(['handler' => HandlerStack::create($mockHandler)]);
        $client     = new SslClient($httpClient);
        $sslPage    = $client->getPage();
        $ssls       = $sslPage->getItems();

        $this->assertEquals(2, count($ssls));
        $this->assertInstanceOf(Ssl::class, $ssls[0]);
        $this->assertInstanceOf(Ssl::class, $ssls[1]);
    }

    /**
     * @test
     * @throws \Exception
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function gets_ssl_by_id()
    {
        $uuid = $this->faker->uuid;
        $mockHandler = new MockHandler([
            new Response(200, [], json_encode([
                'data' => [
                    'id'            => $uuid,
                    'ukfast_ssl_id' => $this->faker->randomDigit,
                    'domains'       => [
                        $this->faker->domainName,
                        $this->faker->domainName,
                    ],
                    'friendly_name' => $this->faker->word,
                    'expires_at'    => $this->faker->dateTimeBetween('+1 day', '+825 days')->format(DateTime::ATOM),
                ]
            ])),
        ]);

        $httpClient = new GuzzleClient(['handler' => HandlerStack::create($mockHandler)]);
        $client     = new SslClient($httpClient);
        $ssl    = $client->getById($uuid);

        $this->assertInstanceOf(Ssl::class, $ssl);
    }

    /**
     * @test
     */
    public function creates_and_gets_ssl_correctly()
    {
        $apiData = [
            'id'            => $this->faker->uuid,
            'ukfast_ssl_id' => $this->faker->randomDigit,
            'domains'       => [
                $this->faker->domainName,
                $this->faker->domainName,
            ],
            'friendly_name' => $this->faker->word,
            'expires_at'    => $this->faker->dateTimeBetween('+1 day', '+825 days')->format(DateTime::ATOM),
        ];

        $mockHandler = new MockHandler([
            new Response(201, [], json_encode([
                'data' => [
                    'id' => $apiData['id'],
                ],
                'meta' => [
                    'location' => 'http://localhost/ddosx/v1/ssls/' . $apiData['id'],
                ],
            ])),
            new Response(200, [], json_encode([
                'data' => $apiData,
                'meta' => [],
            ])),
        ]);

        $httpClient     = new GuzzleClient(['handler' => HandlerStack::create($mockHandler)]);
        $client         = new SslClient($httpClient);
        $createResponse = $client->create(new Ssl($client->apiToFriendly($apiData, SslClient::CERTIFICATE_MAP)));

        $this->assertInstanceOf(SelfResponse::class, $createResponse);

        $this->assertInstanceOf(Ssl::class, $createResponse->get());
    }
}
