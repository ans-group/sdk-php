<?php

namespace Tests\Domains;

use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use UKFast\SDK\Domains\Entities\Lookup;
use UKFast\SDK\Domains\Entities\LookupNameserver;
use UKFast\SDK\Domains\Entities\LookupRegistrar;
use UKFast\SDK\Domains\Entities\LookupRegistry;
use UKFast\SDK\Domains\LookupClient;

class LookupClientTest extends TestCase
{
    /**
     * @test
     * @dataProvider domainsToSanitise
     */
    public function testSanitisesDomains($unsanitised, $sanitised)
    {
        $this->assertEquals($sanitised, (new LookupClient())->sanitiseDomain($unsanitised));
    }

    public function domainsToSanitise()
    {
        return [
            [
                'unsanitised' => 'http://foo.bar',
                'sanitised' => 'foo.bar',
            ],
            [
                'unsanitised' => 'https://foo.bar',
                'sanitised' => 'foo.bar',
            ],
            [
                'unsanitised' => 'http:/foo.bar',
                'sanitised' => 'foo.bar',
            ],
            [
                'unsanitised' => 'https:/foo.bar',
                'sanitised' => 'foo.bar',
            ],
            [
                'unsanitised' => 'foo.bar',
                'sanitised' => 'foo.bar',
            ],
            [
                'unsanitised' => 'foo.bar .baz',
                'sanitised' => 'foo.bar%20.baz',
            ],
            [
                'unsanitised' => 'http://foo.bar/',
                'sanitised' => 'foo.bar',
            ],
            [
                'unsanitised' => 'http://foo.bar ',
                'sanitised' => 'foo.bar',
            ],
        ];
    }

    public function testLookupReturnsLookupEntity()
    {
        $data = [
            'name' => 'ans.co.uk',
            'status' => 'active',
            'registrar' => [
                'name' => 'ANS Group Ltd',
                'url' => 'https://www.ans.co.uk',
                'handle' => 'UKFAST',
                'status' => [],
            ],
            'registry' => [
                'name' => '',
                'url' => '',
                'handle' => '',
                'status' => [],
            ],
            'nameservers' => [
                ['host' => 'mitchell.ns.cloudflare.com.', 'ip' => null],
                ['host' => 'samara.ns.cloudflare.com.', 'ip' => null],
            ],
            'created_at' => '1995-07-12T00:37:56+00:00',
            'updated_at' => '2025-03-25T13:26:00+00:00',
            'expires_at' => '2032-07-12T00:37:56+00:00',
        ];

        $mock = new MockHandler([
            new Response(200, [], json_encode(['data' => $data, 'meta' => []]))
        ]);
        $container = [];
        $history = Middleware::history($container);
        $handler = HandlerStack::create($mock);
        $handler->push($history);

        $client = new LookupClient(new Guzzle(['handler' => $handler]));

        $result = $client->getRecord('http://ans.co.uk/');

        $this->assertEquals('v2/lookup/ans.co.uk', (string) $container[0]['request']->getUri());

        $this->assertInstanceOf(Lookup::class, $result);
        $this->assertEquals('ans.co.uk', $result->name);
        $this->assertEquals('active', $result->status);

        $this->assertInstanceOf(LookupRegistrar::class, $result->registrar);
        $this->assertEquals('ANS Group Ltd', $result->registrar->name);
        $this->assertEquals('https://www.ans.co.uk', $result->registrar->url);
        $this->assertEquals('UKFAST', $result->registrar->handle);
        $this->assertEquals([], $result->registrar->status);

        $this->assertInstanceOf(LookupRegistry::class, $result->registry);
        $this->assertEquals('', $result->registry->name);
        $this->assertEquals('', $result->registry->url);
        $this->assertEquals('', $result->registry->handle);
        $this->assertEquals([], $result->registry->status);

        $this->assertCount(2, $result->nameservers);
        $this->assertInstanceOf(LookupNameserver::class, $result->nameservers[0]);
        $this->assertEquals('mitchell.ns.cloudflare.com.', $result->nameservers[0]->host);
        $this->assertNull($result->nameservers[0]->ip);
        $this->assertEquals('samara.ns.cloudflare.com.', $result->nameservers[1]->host);
        $this->assertNull($result->nameservers[1]->ip);

        $this->assertInstanceOf(\DateTime::class, $result->createdAt);
        $this->assertEquals('1995-07-12T00:37:56+00:00', $result->createdAt->format('c'));
        $this->assertInstanceOf(\DateTime::class, $result->updatedAt);
        $this->assertEquals('2025-03-25T13:26:00+00:00', $result->updatedAt->format('c'));
        $this->assertInstanceOf(\DateTime::class, $result->expiresAt);
        $this->assertEquals('2032-07-12T00:37:56+00:00', $result->expiresAt->format('c'));
    }
}
