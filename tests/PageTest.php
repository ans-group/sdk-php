<?php

namespace Tests;

use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use UKFast\Client;
use UKFast\Page;

class PageTest extends TestCase
{
    /**
     * @test
     */
    public function parses_pagination_meta()
    {
        $page = new Page([(object) [
            'id' => 1,
            'name' => 'test'
        ]], (object) [
            'pagination' => (object) [
                'total' => 10,
                'count' => 1,
                'per_page' => 1,
                'total_pages' => 10,
                'links' => (object) [
                    'next' => 'http://example.com/next',
                    'previous' => null,
                    'first' => 'http://example.com/first',
                    'last' => 'http://example.com/last'
                ]
            ]
        ], new Request('GET', 'http://example.com/endpoint?per_page=1&page=1'));

        $this->assertEquals('http://example.com/next', $page->nextPageUrl());
        $this->assertEquals(null, $page->previousPageUrl());
        $this->assertEquals('http://example.com/first', $page->firstPageUrl());
        $this->assertEquals('http://example.com/last', $page->lastPageUrl());
        $this->assertEquals(10, $page->totalItems());
        $this->assertEquals(10, $page->totalPages());
        $this->assertEquals(1, $page->pageNumber());
    }

    /**
     * @test
     */
    public function loads_next_page()
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode([
                'data' => [[
                    'id' => 2,
                    'name' => 'Test Two',
                ]],
                'meta' => [
                    'pagination' => [
                        'total' => 2,
                        'count' => 1,
                        'per_page' => 1,
                        'total_pages' => 2,
                        'links' => [
                            'next' => 'http://example.com/next',
                            'previous' => null,
                            'first' => 'http://example.com/first',
                            'last' => 'http://example.com/last'
                        ]
                    ]
                ]
            ])),
        ]);
        $container = [];
        $history = Middleware::history($container);
        $handler = HandlerStack::create($mock);
        $handler->push($history);
        $guzzle = new Guzzle(['handler' => $handler]);

        $client = new Client($guzzle);

        $page = new Page([(object) [
            'id' => 1,
            'name' => 'test'
        ]], (object) [
            'pagination' => (object) [
                'total' => 2,
                'count' => 1,
                'per_page' => 1,
                'total_pages' => 2,
                'links' => (object) [
                    'next' => 'http://example.com/endpoint?page=2',
                    'previous' => null,
                    'first' => 'http://example.com/first',
                    'last' => 'http://example.com/last'
                ]
            ]
        ], new Request('GET', 'http://example.com/endpoint?per_page=1'));
        $page->setClient($client);
        $page->serializeWith(function ($item) {
            return $item->id . ' ' . $item->name;
        });

        $nextPage = $page->getNextPage();
        $this->assertEquals(1, count($container));

        $request = $container[0]['request'];
        $this->assertEquals('http://example.com/endpoint?page=2', $request->getUri()->__toString());

        $this->assertEquals(1, count($nextPage->getItems()));
        $this->assertEquals(2, $nextPage->pageNumber());

        $item = $nextPage->getItems()[0];
        $this->assertEquals('2 Test Two', $item);
    }

    /**
     * @test
     */
    public function next_page_returns_false_if_no_next_page()
    {
        $page = new Page([ (object) [
            'id' => 1,
        ]], (object) [
            'pagination' => (object) [
                'total' => 1,
                'count' => 1,
                'per_page' => 1,
                'total_pages' => 1,
                'links' => (object) [
                    'next' => null,
                    'previous' => null,
                    'first' => 'http://example.com/first',
                    'last' => 'http://example.com/last'
                ]
            ]
        ], new Request('GET', 'http://example.com/endpoint?per_page=1'));

        $this->assertFalse($page->getNextPage());
    }

    /**
     * @test
     */
    public function previous_page_returns_false_if_no_next_page()
    {
        $page = new Page([ (object) [
            'id' => 1,
        ]], (object) [
            'pagination' => (object) [
                'total' => 1,
                'count' => 1,
                'per_page' => 1,
                'total_pages' => 1,
                'links' => (object) [
                    'next' => null,
                    'previous' => null,
                    'first' => 'http://example.com/first',
                    'last' => 'http://example.com/last'
                ]
            ]
        ], new Request('GET', 'http://example.com/endpoint?per_page=1'));

        $this->assertFalse($page->getPreviousPage());
    }
}
