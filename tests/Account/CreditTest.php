<?php

namespace Tests\Account;

use Faker\Factory as Faker;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use UKFast\SDK\Account\CreditClient;

class CreditTest extends TestCase
{
    /**
     * Faker data provider
     *
     * @var \Faker\Generator
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
    public function getPage()
    {
        $apiResponse = [
            'data' => [
                [
                    'type'      => $this->faker->word,
                    'total'     => $this->faker->numberBetween(10),
                    'remaining' => $this->faker->randomDigitNotNull,
                ]
            ],
            'meta' => [
                'pagination' => [
                    'total'        => 1,
                    'count'        => 1,
                    'per_page'     => 20,
                    'current_page' => 1,
                    'total_pages'  => 1,
                    'links'        => [
                        'first'    => null,
                        'previous' => null,
                        'next'     => null,
                        'last'     => null,
                    ]
                ]
            ],
        ];

        $mock = new MockHandler([
            new Response(200, [], json_encode($apiResponse)),
        ]);

        $guzzle  = new Client(['handler' => HandlerStack::create($mock)]);
        $client  = new CreditClient($guzzle);
        $credits = $client->getPage()->getItems();

        $this->assertSameSize($apiResponse['data'], $credits);
        $this->assertEquals($apiResponse['data'][0]['type'], $credits[0]->type);
        $this->assertEquals($apiResponse['data'][0]['total'], $credits[0]->total);
        $this->assertEquals($apiResponse['data'][0]['remaining'], $credits[0]->remaining);
    }
}
