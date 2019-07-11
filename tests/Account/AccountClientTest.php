<?php

namespace Tests\Account;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class AccountClientTest extends TestCase
{
    /**
     * @test
     */
    public function gets_a_page_of_requests()
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode([
                'data' => [
                    [
                    'id' => 100,
                    'type' => 'Domains',
                    'value' => 'example.com',
                    ],
                    [
                        'id' => 156,
                        'type' => 'Domains',
                        'value' => 'ukfast.co.uk',
                    ],
                ],
                'meta' => [
                    'pagination' => [
                        'total' => 2,
                        'count' => 1,
                        'per_page' => 1,
                        'total_pages' => 1,
                        'links' => [
                            'next' => 'http://example.com/next',
                            'previous' => 'http://example.com/previous',
                            'first' => 'http://example.com/first',
                            'last' => 'http://example.com/last',
                        ]
                    ]
                ]
            ])),
        ]);
        $handler = HandlerStack::create($mock);
        $guzzle = new Client(['handler' => $handler]);

        $client = new \UKFast\SDK\Account\Client($guzzle);
        $page = $client->products()->getPage();

        $this->assertTrue($page instanceof \UKFast\SDK\Page);
        $product = $page->getItems()[0];

        $this->assertEquals(100, $product->id);
        $this->assertEquals('Domains', $product->type);
        $this->assertEquals('example.com', $product->value);
    }
}
