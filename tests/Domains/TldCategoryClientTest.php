<?php

namespace Tests\Domains;

use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use UKFast\SDK\Domains\Entities\TldCategory;
use UKFast\SDK\Domains\TldCategoryClient;

class TldCategoryClientTest extends TestCase
{
    public function testListsCategoriesUsingTheV2Endpoint()
    {
        $history = [];
        $handler = HandlerStack::create(new MockHandler([
            new Response(200, [], json_encode([
                'data' => [['name' => 'Technology', 'order' => 3]],
                'meta' => ['pagination' => ['total' => 1, 'count' => 1, 'per_page' => 50, 'total_pages' => 1]],
            ])),
        ]));
        $handler->push(Middleware::history($history));
        $client = new TldCategoryClient(new Guzzle(['handler' => $handler]));

        $page = $client->getPage(1, 50);

        $this->assertStringStartsWith('v2/tld-categories?', (string) $history[0]['request']->getUri());
        $this->assertInstanceOf(TldCategory::class, $page->getItems()[0]);
        $this->assertEquals('Technology', $page->getItems()[0]->name);
        $this->assertEquals(3, $page->getItems()[0]->order);
    }
}
