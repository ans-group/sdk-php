<?php

namespace Tests;

use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use UKFast\Client;
use UKFast\Exception\ApiException;
use UKFast\Exception\InvalidJsonException;
use UKFast\Page;

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
}
