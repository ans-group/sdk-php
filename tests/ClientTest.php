<?php

namespace Tests;

use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use UKFast\SDK\Client;
use UKFast\SDK\Exception\ApiException;
use UKFast\SDK\Exception\InvalidJsonException;
use UKFast\SDK\Exception\NotFoundException;
use UKFast\SDK\Exception\ValidationException;
use UKFast\SDK\Exception\PreconditionFailedException;
use UKFast\SDK\Page;

class ClientTest extends TestCase
{
    /**
     * @test
     */
    public function sends_authentication_header()
    {
        $mock = new MockHandler([
            new Response(200, []),
        ]);
        $container = [];
        $history = Middleware::history($container);
        $handler = HandlerStack::create($mock);
        $handler->push($history);
        $guzzle = new Guzzle(['handler' => $handler]);

        $client = new Client($guzzle);

        $client->auth("Test token");
        $client->request("GET", "/");
        
        $this->assertEquals(1, count($container));
        $headers = $container[0]['request']->getHeaders();

        $this->assertEquals(1, count($headers['Authorization']));
        $this->assertEquals('Test token', $headers['Authorization'][0]);
    }

    /**
     * @test
     */
    public function sends_user_agent_header()
    {
        $mock = new MockHandler([
            new Response(200, []),
        ]);
        $container = [];
        $history = Middleware::history($container);
        $handler = HandlerStack::create($mock);
        $handler->push($history);
        $guzzle = new Guzzle([
            'handler' => $handler,
            'headers' => [
                'User-Agent' => 'Test/1.0'
            ]
        ]);

        $client = new Client($guzzle);
        $client->request("GET", "/");
        
        $this->assertEquals(1, count($container));
        $headers = $container[0]['request']->getHeaders();

        $this->assertEquals(1, count($headers['User-Agent']));

        $this->assertEquals('Test/1.0', $headers['User-Agent'][0]);
    }

    /**
     * @test
     */
    public function sends_user_agent_header_with_auth()
    {
        $mock = new MockHandler([
            new Response(200, []),
        ]);
        $container = [];
        $history = Middleware::history($container);
        $handler = HandlerStack::create($mock);
        $handler->push($history);
        $guzzle = new Guzzle([
            'handler' => $handler,
            'headers' => [
                'User-Agent' => 'Test/1.0'
            ]
        ]);

        $client = new Client($guzzle);
        $client->auth('token');
        $client->request("GET", "/");
        
        $this->assertEquals(1, count($container));
        $headers = $container[0]['request']->getHeaders();

        $this->assertEquals(1, count($headers['User-Agent']));

        $this->assertEquals('Test/1.0', $headers['User-Agent'][0]);
    }

    /**
     * @test
     */
    public function merges_authentication_header_with_provided_headers()
    {
        $mock = new MockHandler([
            new Response(200, []),
        ]);
        $container = [];
        $history = Middleware::history($container);
        $handler = HandlerStack::create($mock);
        $handler->push($history);
        $guzzle = new Guzzle(['handler' => $handler]);

        $client = new Client($guzzle);

        $client->auth("Test token");
        $client->request("GET", "/", null, [
            'X-Custom-Header' => 1,
        ]);
        
        $this->assertEquals(1, count($container));
        $headers = $container[0]['request']->getHeaders();

        $this->assertEquals(1, count($headers['Authorization']));
        $this->assertEquals('Test token', $headers['Authorization'][0]);

        $this->assertEquals(1, count($headers['X-Custom-Header']));
        $this->assertEquals(1, $headers['X-Custom-Header'][0]);
    }

    /**
     * @test
     */
    public function makes_paginated_requests()
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode([
                'data' => [[
                    'id' => 1,
                    'name' => 'First',
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
        $guzzle = new Guzzle(['handler' => $handler]);

        $client = new Client($guzzle);

        $page = $client->paginatedRequest("/", $page = 1, $perPage = 1);

        $this->assertTrue($page instanceof Page);
        $this->assertEquals("http://example.com/next", $page->nextPageUrl());
        $this->assertEquals(1, $page->getItems()[0]->id);
    }

    /**
     * @test
     */
    public function throws_invalid_json_exception()
    {
        $mock = new MockHandler([
            new Response(200, [], 'invalid json'),
        ]);
        $handler = HandlerStack::create($mock);
        $guzzle = new Guzzle(['handler' => $handler]);

        $client = new Client($guzzle);

        $this->expectException(InvalidJsonException::class);
        $client->paginatedRequest("/", 1, 10);
    }

    /**
     * @test
     */
    public function throws_not_found_exception()
    {
        $mock = new MockHandler([
            new Response(404, [], '{"errors": [{"detail": "Testing"}]}'),
        ]);
        $handler = HandlerStack::create($mock);
        $guzzle = new Guzzle(['handler' => $handler]);

        $client = new Client($guzzle);

        $this->expectException(NotFoundException::class);
        $client->paginatedRequest("/", 1, 10);
    }

    public function validationErrorStatuses()
    {
        return [
            '400' => [400],
            '422' => [422],
        ];
    }

    /**
     * @dataProvider validationErrorStatuses
     * @test
     */
    public function throws_validation_exception($statusCode)
    {
        $mock = new MockHandler([
            new Response($statusCode, [], '{"errors": [{"detail": "Testing"}]}'),
        ]);
        $handler = HandlerStack::create($mock);
        $guzzle = new Guzzle(['handler' => $handler]);

        $client = new Client($guzzle);

        $this->expectException(ValidationException::class);
        $client->paginatedRequest("/", 1, 10);
    }

    /**
     * @test
     */
    public function wraps_client_exceptions_as_ukfast_exceptions()
    {
        $mock = new MockHandler([
            new Response(400, [], json_encode([
                'errors' => [[
                    'title' => 'Testing errors',
                    'detail' => 'Testing errors detail',
                    'status' => 400,
                    'source' => 'test'
                ]]
            ])),
        ]);
        $handler = HandlerStack::create($mock);
        $guzzle = new Guzzle(['handler' => $handler]);
        $client = new Client($guzzle);

        try {
            $client->request('GET', '/');
        } catch (ApiException $e) {
            $this->assertEquals(1, count($e->getErrors()));
            $this->assertEquals('Testing errors detail', $e->getMessage());
            return;
        }

        $this->expectException(ApiException::class);
    }

    /**
     * @test
     */
    public function wraps_server_exceptions_as_ukfast_exceptions()
    {
        $mock = new MockHandler([
            new Response(500, [], json_encode([
                'errors' => [[
                    'title' => 'Testing errors',
                    'detail' => 'Testing errors',
                    'status' => 500,
                ]]
            ])),
        ]);
        $handler = HandlerStack::create($mock);
        $guzzle = new Guzzle(['handler' => $handler]);
        $client = new Client($guzzle);

        try {
            $client->request('GET', '/');
        } catch (ApiException $e) {
            $this->assertEquals(1, count($e->getErrors()));
            $this->assertEquals('Testing errors', $e->getMessage());
            return;
        }

        $this->expectException(ApiException::class);
    }

    /**
     * @test
     */
    public function defaults_exception_message_to_title_if_no_detail_is_set()
    {
        $mock = new MockHandler([
            new Response(500, [], json_encode([
                'errors' => [[
                    'title' => 'Testing errors title',
                    'status' => 500,
                ]]
            ])),
        ]);
        $handler = HandlerStack::create($mock);
        $guzzle = new Guzzle(['handler' => $handler]);
        $client = new Client($guzzle);

        try {
            $client->request('GET', '/');
        } catch (ApiException $e) {
            $this->assertEquals('Testing errors title', $e->getMessage());
            return;
        }

        $this->expectException(ApiException::class);
    }

    /**
     * @test
     */
    public function get_sends_get_requests()
    {
        $mock = new MockHandler([
            new Response(200, []),
        ]);
        $container = [];
        $history = Middleware::history($container);
        $handler = HandlerStack::create($mock);
        $handler->push($history);
        $guzzle = new Guzzle(['handler' => $handler]);
        $client = new Client($guzzle);

        $client->get("/");
        
        $this->assertEquals(1, count($container));
        $this->assertEquals('GET', $container[0]['request']->getMethod());
    }

    /**
     * @test
     */
    public function post_sends_post_requests()
    {
        $mock = new MockHandler([
            new Response(200, []),
        ]);
        $container = [];
        $history = Middleware::history($container);
        $handler = HandlerStack::create($mock);
        $handler->push($history);
        $guzzle = new Guzzle(['handler' => $handler]);
        $client = new Client($guzzle);
        
        $client->post("/", json_encode(['name' => 'bing']));
        
        $this->assertEquals(1, count($container));
        $this->assertEquals('POST', $container[0]['request']->getMethod());
        $this->assertEquals('{"name":"bing"}', $container[0]['request']->getBody()->getContents());
    }

    /**
     * @test
     */
    public function patch_sends_patch_requests()
    {
        $mock = new MockHandler([
            new Response(200, []),
        ]);
        $container = [];
        $history = Middleware::history($container);
        $handler = HandlerStack::create($mock);
        $handler->push($history);
        $guzzle = new Guzzle(['handler' => $handler]);
        $client = new Client($guzzle);
        
        $client->patch("/");
        
        $this->assertEquals(1, count($container));
        $this->assertEquals('PATCH', $container[0]['request']->getMethod());
    }

    /**
     * @test
     */
    public function put_sends_put_requests()
    {
        $mock = new MockHandler([
            new Response(200, []),
        ]);
        $container = [];
        $history = Middleware::history($container);
        $handler = HandlerStack::create($mock);
        $handler->push($history);
        $guzzle = new Guzzle(['handler' => $handler]);
        $client = new Client($guzzle);
        
        $client->put("/");
        
        $this->assertEquals(1, count($container));
        $this->assertEquals('PUT', $container[0]['request']->getMethod());
    }

    /**
     * @test
     */
    public function delete_sends_delete_requests()
    {
        $mock = new MockHandler([
            new Response(200, []),
        ]);
        $container = [];
        $history = Middleware::history($container);
        $handler = HandlerStack::create($mock);
        $handler->push($history);
        $guzzle = new Guzzle(['handler' => $handler]);
        $client = new Client($guzzle);
        
        $client->delete("/");
        
        $this->assertEquals(1, count($container));
        $this->assertEquals('DELETE', $container[0]['request']->getMethod());
    }

    /**
     * @test
     */
    public function maps_friendly_names_to_api_names()
    {
        $map = ['created_at' => 'createdAt'];
        $api = (new Client)->friendlyToApi([
            'id' => 1,
            'createdAt' => '2018-01-01 10:00:00',
            'name' => 'Test',
        ], $map);

        $this->assertEquals([
            'id' => 1,
            'created_at' => '2018-01-01 10:00:00',
            'name' => 'Test',
        ], $api);
    }

    /**
     * @test
     */
    public function maps_api_names_to_friendly_names()
    {
        $map = ['created_at' => 'createdAt'];
        $friendly = (new Client)->apiToFriendly([
            'id' => 1,
            'created_at' => '2018-01-01 10:00:00',
            'name' => 'Test',
        ], $map);

        $this->assertEquals([
            'id' => 1,
            'createdAt' => '2018-01-01 10:00:00',
            'name' => 'Test',
        ], $friendly);
    }

    /**
     * @test
     */
    public function maps_api_names_to_friendly_names_with_filters()
    {
        $map = ['key_with_filter' => 'keyWithFilter'];
        $friendly = (new Client)->apiToFriendly([
            'key_with_filter:eq' => 1,
        ], $map);

        $this->assertEquals([
            'keyWithFilter:eq' => 1,
        ], $friendly);
    }

    /**
     * @test
     */
    public function maps_friendly_names_to_api_names_with_filters()
    {
        $map = ['key_with_filter' => 'keyWithFilter'];
        $friendly = (new Client)->friendlyToApi([
            'keyWithFilter:eq' => 1,
        ], $map);

        $this->assertEquals([
            'key_with_filter:eq' => 1,
        ], $friendly);
    }

    /**
     * @test
     */
    public function maps_api_names_to_friendly_names_without_mapping()
    {
        $friendly = (new Client)->apiToFriendly([
            'key_not_existing' => 'na',
        ], []);

        $this->assertEquals([
            'key_not_existing' => 'na',
        ], $friendly);
    }

    /**
     * @test
     */
    public function maps_friendly_names_to_api_names_without_mapping()
    {
        $friendly = (new Client)->friendlyToApi([
            'key_not_existing' => 1,
        ], []);

        $this->assertEquals([
            'key_not_existing' => 1,
        ], $friendly);
    }

    /**
     * @test
     */
    public function throws_precondition_failed_exception()
    {
        $mock = new MockHandler([
            new Response(412, [], '{"errors": [{"detail": "Testing"}]}'),
        ]);
        $handler = HandlerStack::create($mock);
        $guzzle = new Guzzle(['handler' => $handler]);

        $client = new Client($guzzle);

        $this->expectException(PreconditionFailedException::class);
        $client->paginatedRequest("/", 1, 10);
    }
}
