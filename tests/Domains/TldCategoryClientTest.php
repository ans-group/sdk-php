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
    public function testGetsAllCategoriesFromTheUnpaginatedV2Endpoint()
    {
        $history = [];
        $handler = HandlerStack::create(new MockHandler([
            new Response(200, [], json_encode([
                'data' => [['name' => 'Technology'], ['name' => 'Geographic']],
                'meta' => [],
            ])),
        ]));
        $handler->push(Middleware::history($history));
        $client = new TldCategoryClient(new Guzzle(['handler' => $handler]));

        $categories = $client->getAll();

        $this->assertEquals('v2/tld-categories', (string) $history[0]['request']->getUri());
        $this->assertInstanceOf(TldCategory::class, $categories[0]);
        $this->assertEquals('Technology', $categories[0]->name);
        $this->assertEquals('Geographic', $categories[1]->name);
    }

    public function testGetsAnEmptyListWhenTheCatalogueHasNoCategories()
    {
        $handler = HandlerStack::create(new MockHandler([
            new Response(200, [], json_encode(['data' => [], 'meta' => []])),
        ]));
        $client = new TldCategoryClient(new Guzzle(['handler' => $handler]));

        $this->assertSame([], $client->getAll());
    }
}
