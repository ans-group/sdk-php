<?php

namespace Tests;

use DateTime;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use UKFast\SDK\PSS\Entities\Attachment;

class PssClientTest extends TestCase
{
    /**
     * @test
     */
    public function gets_a_page_of_requests()
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode([
                'data' => [[
                    'id' => 1,
                    'subject' => 'First',
                    'author' => [
                        'id' => 10,
                        'name' => 'Test Man',
                        'type' => 'Client'
                    ],
                    'type' => 'Client',
                    'secure' => true,
                    'created_at' => '2000-01-01T00:00:00+00',
                    'priority' => 'Normal',
                    'archived' => true,
                    'status' => 'Submitted',
                    'request_sms' => false,
                    'customer_reference' => 'Test Reference',
                    'product' => [
                        'id' => 100,
                        'type' => 'Domains',
                    ],
                    'last_replied_at' => '2019-07-01T10:11:52+00:00',
                ]],
                'meta' => [
                    'pagination' => [
                        'total' => 2,
                        'count' => 1,
                        'per_page' => 1,
                        'total_pages' => 2,
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

        $client = new \UKFast\SDK\PSS\Client($guzzle);
        $page = $client->requests()->getPage();

        $this->assertTrue($page instanceof \UKFast\SDK\Page);
        $request = $page->getItems()[0];

        $this->assertTrue($request instanceof \UKFast\SDK\PSS\Entities\Request);
        $this->assertEquals(1, $request->id);
        $this->assertEquals('First', $request->subject);
        $this->assertEquals('Test Reference', $request->customerReference);
        $this->assertInstanceOf(DateTime::class, $request->createdAt);
        $this->assertInstanceOf(DateTime::class, $request->lastRepliedAt);
    }

    /**
     * @test
     */
    public function gets_a_conversation()
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode([
                'data' => [[
                    'author' => [
                        'id' => 1,
                        'name' => 'Jonny Test',
                        'type' => 'Client',
                    ],
                    'description' => 'Test',
                    'created_at' => '2000-01-01T00:00:00+00',
                    'attachments' => [],
                ]],
                'meta' => [
                    'pagination' => [
                        'total' => 2,
                        'count' => 1,
                        'per_page' => 1,
                        'total_pages' => 2,
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

        $client = new \UKFast\SDK\PSS\Client($guzzle);
        $page = $client->conversation()->getPage(1);

        $this->assertTrue($page instanceof \UKFast\SDK\Page);

        $reply = $page->getItems()[0];

        $this->assertEquals(1, $reply->author->id);
        $this->assertEquals('Jonny Test', $reply->author->name);
        $this->assertEquals('Test', $reply->description);
        $this->assertInstanceOf(DateTime::class, $reply->createdAt);
        $this->assertEquals('2000-01-01 00:00:00', $reply->createdAt->format('Y-m-d H:i:s'));
    }

    /**
     * @test
     */
    public function gets_a_conversation_with_attachments()
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode([
                'data' => [[
                    'author' => [
                        'id' => 1,
                        'name' => 'Jonny Test',
                        'type' => 'Client',
                    ],
                    'description' => 'Test',
                    'created_at' => '2000-01-01T00:00:00+00',
                    'attachments' => [
                        [
                            'name' => 'test-file.txt',
                        ],
                        [
                            'name' => 'test-file2.txt',
                        ],
                    ]
                ]],
                'meta' => [
                    'pagination' => [
                        'total' => 2,
                        'count' => 1,
                        'per_page' => 1,
                        'total_pages' => 2,
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

        $client = new \UKFast\SDK\PSS\Client($guzzle);
        $page = $client->conversation()->getPage(1);

        $this->assertTrue($page instanceof \UKFast\SDK\Page);

        $reply = $page->getItems()[0];

        $this->assertCount(2, $reply->attachments);
        $this->assertInstanceOf(Attachment::class, $reply->attachments[0]);
        $this->assertInstanceOf(Attachment::class, $reply->attachments[1]);
        $this->assertEquals('test-file.txt', $reply->attachments[0]->name);
        $this->assertEquals('test-file2.txt', $reply->attachments[1]->name);
    }

    /**
     * @test
     */
    public function gets_one_request()
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode([
                'data' => [
                    'id' => 1,
                    'subject' => 'First',
                    'author' => [
                        'id' => 10,
                        'name' => 'Test Man',
                        'type' => 'Client'
                    ],
                    'type' => 'Client',
                    'secure' => true,
                    'created_at' => '2000-01-01T00:00:00+00',
                    'priority' => 'Normal',
                    'archived' => true,
                    'status' => 'Submitted',
                    'request_sms' => false,
                    'customer_reference' => 'Test Reference',
                    'product' => [
                        'id' => 100,
                        'type' => 'Domains',
                    ],
                    'last_replied_at' => '2019-07-01T10:11:52+00:00',
                ],
            ])),
        ]);
        $handler = HandlerStack::create($mock);
        $guzzle = new Client(['handler' => $handler]);

        $client = new \UKFast\SDK\PSS\Client($guzzle);
        $request = $client->requests()->getById(1);

        $this->assertTrue($request instanceof \UKFast\SDK\PSS\Entities\Request);
        $this->assertEquals(1, $request->id);
        $this->assertEquals('First', $request->subject);
        $this->assertEquals('Test Reference', $request->customerReference);
        $this->assertInstanceOf(DateTime::class, $request->createdAt);
        $this->assertInstanceOf(DateTime::class, $request->lastRepliedAt);
    }
}
