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
                    'system_reference' => 'test-system-reference-001',
                    'product' => [
                        'id' => 100,
                        'type' => 'Domains',
                    ],
                    'last_replied_at' => '2019-07-01T10:11:52+00:00',
                    'unread_replies' => 2,
                    'contact_method' => 'Mobile',
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
        $this->assertEquals('test-system-reference-001', $request->systemReference);
        $this->assertEquals(2, $request->unreadReplies);
        $this->assertInstanceOf(DateTime::class, $request->createdAt);
        $this->assertInstanceOf(DateTime::class, $request->lastRepliedAt);
    }

    /**
     * @test
     */
    public function gets_replies()
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode([
                'data' => [[
                    'id' => 1,
                    'request_id' => 123456,
                    'author' => [
                        'id' => 1,
                        'name' => 'Jonny Test',
                        'type' => 'Client',
                    ],
                    'description' => 'Test',
                    'created_at' => '2000-01-01T00:00:00+00',
                    'attachments' => [],
                    'read' => false,
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
        $page = $client->replies()->getPage(1);

        $this->assertTrue($page instanceof \UKFast\SDK\Page);

        $reply = $page->getItems()[0];

        $this->assertEquals(1, $reply->id);
        $this->assertEquals(123456, $reply->requestId);
        $this->assertEquals(1, $reply->author->id);
        $this->assertEquals('Jonny Test', $reply->author->name);
        $this->assertFalse($reply->read);
        $this->assertEquals('Test', $reply->description);
        $this->assertInstanceOf(DateTime::class, $reply->createdAt);
        $this->assertEquals('2000-01-01 00:00:00', $reply->createdAt->format('Y-m-d H:i:s'));
    }

    /**
     * @test
     */
    public function gets_replies_with_attachments()
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode([
                'data' => [[
                    'id' => 1,
                    'request_id' => 123456,
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
                    ],
                    'read' => true,
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
        $page = $client->replies()->getPage(1);

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
                    'system_reference' => 'test-system-reference-001',
                    'product' => [
                        'id' => 100,
                        'type' => 'Domains',
                    ],
                    'cc' => [],
                    'last_replied_at' => '2019-07-01T10:11:52+00:00',
                    'unread_replies' => 2,
                    'contact_method' => 'Email',
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
        $this->assertEquals('test-system-reference-001', $request->systemReference);
        $this->assertEquals('Email', $request->contactMethod);
        $this->assertInstanceOf(DateTime::class, $request->createdAt);
        $this->assertInstanceOf(DateTime::class, $request->lastRepliedAt);
        $this->assertEquals([], $request->cc);
    }

    public function gets_one_request_with_cc()
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
                    'system_reference' => 'test-system-reference-001',
                    'product' => [
                        'id' => 100,
                        'type' => 'Domains',
                    ],
                    'cc' => [
                        'example@example.com',
                        'test@example.com',
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
        $this->assertEquals('test-system-reference-001', $request->systemReference);
        $this->assertInstanceOf(DateTime::class, $request->createdAt);
        $this->assertInstanceOf(DateTime::class, $request->lastRepliedAt);
        $this->assertEquals(['example@example.com', 'test@example.com'], $request->cc);
    }

    /**
     * @test
     */
    public function gets_one_reply()
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode([
                'data' => [
                    'id' => "C485939",
                    'request_id' => 123456,
                    'author' => [
                        'id' => 10,
                        'name' => 'Test Man',
                        'type' => 'Client'
                    ],
                    'description' => 'test',
                    'attachments' => [],
                    'created_at' => '2000-01-01T00:00:00+00',
                    'read' => true,
                ],
                'meta' => ''
            ])),
        ]);
        $handler = HandlerStack::create($mock);
        $guzzle = new Client(['handler' => $handler]);

        $client = new \UKFast\SDK\PSS\Client($guzzle);
        $reply = $client->replies()->getById('C485939');

        $this->assertTrue($reply instanceof \UKFast\SDK\PSS\Entities\Reply);
        $this->assertEquals('C485939', $reply->id);
        $this->assertEquals(123456, $reply->requestId);
        $this->assertEquals('test', $reply->description);
        $this->assertInstanceOf(DateTime::class, $reply->createdAt);
        $this->assertTrue($reply->read);
    }

    /**
     * @test
     */
    public function gets_replies_without_request_id()
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode([
                'data' => [
                    [
                        'id' => 1,
                        'request_id' => 123456,
                        'author' => [
                            'id' => 1,
                            'name' => 'Jonny Test',
                            'type' => 'Client',
                        ],
                        'description' => 'Test',
                        'created_at' => '2000-01-01T00:00:00+00',
                        'attachments' => [],
                        'read' => false,
                    ],
                    [
                        'id' => 1,
                        'request_id' => 654321,
                        'author' => [
                            'id' => 1,
                            'name' => 'Jonny Test',
                            'type' => 'Client',
                        ],
                        'description' => 'Test 2',
                        'created_at' => '2000-01-01T00:00:00+00',
                        'attachments' => [],
                        'read' => false,
                    ]
                ],
                'meta' => [
                    'pagination' => [
                        'total' => 2,
                        'count' => 1,
                        'per_page' => 2,
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

        $client = new \UKFast\SDK\PSS\Client($guzzle);
        $page = $client->replies()->getPageWithoutRequest();

        $this->assertTrue($page instanceof \UKFast\SDK\Page);

        $reply = $page->getItems()[0];

        $this->assertEquals(1, $reply->id);
        $this->assertEquals(123456, $reply->requestId);
        $this->assertEquals(1, $reply->author->id);
        $this->assertEquals('Jonny Test', $reply->author->name);
        $this->assertFalse($reply->read);
        $this->assertEquals('Test', $reply->description);
        $this->assertInstanceOf(DateTime::class, $reply->createdAt);
        $this->assertEquals('2000-01-01 00:00:00', $reply->createdAt->format('Y-m-d H:i:s'));
    }
}
