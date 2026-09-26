<?php

namespace Tests\Domains;

use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use UKFast\SDK\Domains\DomainClient;
use UKFast\SDK\Domains\Entities\Domain;
use UKFast\SDK\Domains\Entities\DomainRegistrant;
use UKFast\SDK\Domains\Entities\DomainRegistrantAddress;
use UKFast\SDK\Domains\Entities\DomainRegistrantCompany;
use UKFast\SDK\Domains\Entities\DomainRegistrantContact;
use UKFast\SDK\Domains\Entities\Nameserver;

class DomainClientTest extends TestCase
{
    /**
     * @var array
     */
    private $history = [];

    /**
     * @param Response[] $responses
     * @return DomainClient
     */
    private function client($responses)
    {
        $this->history = [];
        $handler = HandlerStack::create(new MockHandler($responses));
        $handler->push(Middleware::history($this->history));

        return new DomainClient(new Guzzle(['handler' => $handler]));
    }

    /**
     * @return \Psr\Http\Message\RequestInterface
     */
    private function lastRequest()
    {
        return end($this->history)['request'];
    }

    private function domainData()
    {
        return [
            'name' => 'edgeley.community',
            'registrar' => ['name' => 'Tucows'],
            'client' => ['id' => 8566, 'name' => 'Edgeley Community Association'],
            'registration' => ['date' => '2022-11-25', 'status' => 'Registered until expiry date'],
            'renewal' => ['date' => '2027-11-25', 'auto' => true],
            'transfer' => ['locked' => false],
            'expiry' => ['date' => '2027-11-25'],
            'registrant' => ['privacy' => true],
            'created_at' => '2022-11-25T12:00:00+00:00',
            'updated_at' => '2026-09-26T19:39:39+01:00',
        ];
    }

    public function testGetByNameReadsTheV2DomainIntoTheExistingProperties()
    {
        $client = $this->client([
            new Response(200, [], json_encode(['data' => $this->domainData(), 'meta' => []])),
        ]);

        $domain = $client->getByName('edgeley.community');

        $this->assertEquals('GET', $this->lastRequest()->getMethod());
        $this->assertEquals('v2/domains/edgeley.community', (string) $this->lastRequest()->getUri());
        $this->assertInstanceOf(Domain::class, $domain);

        // The properties a v1 domain had, with the same values v1 gives.
        $this->assertEquals('edgeley.community', $domain->name);
        $this->assertEquals('Registered until expiry date', $domain->status);
        $this->assertEquals(8566, $domain->clientId);
        $this->assertEquals('Tucows', $domain->registrar);
        $this->assertEquals('2022-11-25', $domain->registeredAt);
        $this->assertEquals('2027-11-25', $domain->renewalAt);
        $this->assertTrue($domain->autoRenew);
        $this->assertTrue($domain->whoisPrivacy);

        // v2's record timestamp: v1 gave a date that stayed at the
        // registration date, even after a renewal.
        $this->assertEquals('2026-09-26T19:39:39+01:00', $domain->updatedAt);

        // Only in v2.
        $this->assertEquals('Edgeley Community Association', $domain->clientName);
        $this->assertEquals('2027-11-25', $domain->expiresAt);
        $this->assertFalse($domain->transferLocked);
        $this->assertEquals('2022-11-25T12:00:00+00:00', $domain->createdAt);
    }

    public function testGetPageListsV2Domains()
    {
        $client = $this->client([
            new Response(200, [], json_encode([
                'data' => [$this->domainData()],
                'meta' => ['pagination' => ['total' => 1, 'count' => 1, 'per_page' => 49, 'total_pages' => 1]],
            ])),
        ]);

        $page = $client->getPage(1, 49);

        $this->assertStringStartsWith('v2/domains?', (string) $this->lastRequest()->getUri());
        $this->assertNotFalse(strpos((string) $this->lastRequest()->getUri(), 'per_page=49'));
        $this->assertInstanceOf(Domain::class, $page->getItems()[0]);
        $this->assertEquals('2027-11-25', $page->getItems()[0]->renewalAt);
    }

    public function testUpdateSendsOnlyAutoRenew()
    {
        $client = $this->client([
            new Response(200, [], json_encode(['data' => ['id' => 'edgeley.community'], 'meta' => []])),
        ]);

        $domain = new Domain();
        $domain->name = 'edgeley.community';
        $domain->autoRenew = false;
        $domain->whoisPrivacy = false;

        $this->assertTrue($client->update($domain));
        $this->assertEquals('PATCH', $this->lastRequest()->getMethod());
        $this->assertEquals('v2/domains/edgeley.community', (string) $this->lastRequest()->getUri());
        $this->assertEquals(
            ['renewal' => ['auto' => false]],
            json_decode((string) $this->lastRequest()->getBody(), true)
        );
    }

    public function testDeleteByNameDeletesTheV2Domain()
    {
        $client = $this->client([new Response(204)]);

        $this->assertTrue($client->deleteByName('edgeley.community'));
        $this->assertEquals('DELETE', $this->lastRequest()->getMethod());
        $this->assertEquals('v2/domains/edgeley.community', (string) $this->lastRequest()->getUri());
    }

    public function testGetNameserversByNameReadsV2Nameservers()
    {
        $client = $this->client([
            new Response(200, [], json_encode([
                'data' => [
                    ['host' => 'ns0.ukfast.net', 'ip' => null],
                    ['host' => 'ns1.ukfast.net', 'ip' => null],
                ],
                'meta' => [],
            ])),
        ]);

        $nameservers = $client->getNameserversByName('edgeley.community');

        $this->assertEquals('v2/domains/edgeley.community/nameservers', (string) $this->lastRequest()->getUri());
        $this->assertCount(2, $nameservers);
        $this->assertInstanceOf(Nameserver::class, $nameservers[0]);
        $this->assertEquals('ns0.ukfast.net', $nameservers[0]->host);
        $this->assertNull($nameservers[0]->ip);
    }

    public function testUpdateNameserversReplacesTheWholeList()
    {
        $client = $this->client([
            new Response(200, [], json_encode(['data' => ['id' => 'example.co.uk'], 'meta' => []])),
        ]);

        $this->assertTrue($client->updateNameservers('example.co.uk', [
            new Nameserver((object) ['host' => 'ns1.example.co.uk', 'ip' => '203.0.113.10']),
            new Nameserver((object) ['host' => 'ns2.example.net']),
        ]));

        $this->assertEquals('PUT', $this->lastRequest()->getMethod());
        $this->assertEquals('v2/domains/example.co.uk/nameservers', (string) $this->lastRequest()->getUri());
        $this->assertEquals([
            ['host' => 'ns1.example.co.uk', 'ip' => '203.0.113.10'],
            ['host' => 'ns2.example.net', 'ip' => null],
        ], json_decode((string) $this->lastRequest()->getBody(), true));
    }

    public function testGetRegistrantByNameReadsTheRegistrant()
    {
        $client = $this->client([
            new Response(200, [], json_encode([
                'data' => [
                    'name' => 'Example Ltd',
                    'type' => 'LTD',
                    'company' => ['number' => '01234567', 'trading_as' => 'Example'],
                    'contact' => ['name' => 'Jane Smith', 'email' => 'jane@example.co.uk', 'phone' => '+44.1234567890'],
                    'address' => [
                        'line1' => '1 High Street',
                        'line2' => null,
                        'city' => 'Stockport',
                        'county' => 'Greater Manchester',
                        'postcode' => 'SK1 1AA',
                        'country' => 'GB',
                    ],
                ],
                'meta' => [],
            ])),
        ]);

        $registrant = $client->getRegistrantByName('example.co.uk');

        $this->assertEquals('v2/domains/example.co.uk/registrant', (string) $this->lastRequest()->getUri());
        $this->assertInstanceOf(DomainRegistrant::class, $registrant);
        $this->assertEquals('Example Ltd', $registrant->name);
        $this->assertEquals('LTD', $registrant->type);
        $this->assertEquals('01234567', $registrant->company->number);
        $this->assertEquals('Example', $registrant->company->tradingAs);
        $this->assertEquals('jane@example.co.uk', $registrant->contact->email);
        $this->assertEquals('SK1 1AA', $registrant->address->postcode);
        $this->assertNull($registrant->address->line2);
    }

    public function testUpdateRegistrantSendsEveryFieldButTheName()
    {
        $client = $this->client([
            new Response(200, [], json_encode(['data' => ['id' => 'example.co.uk'], 'meta' => []])),
        ]);

        $registrant = new DomainRegistrant([
            'name' => 'Example Ltd',
            'type' => 'LTD',
            'company' => new DomainRegistrantCompany(['number' => '01234567', 'tradingAs' => null]),
            'contact' => new DomainRegistrantContact([
                'name' => 'Jane Smith',
                'email' => 'jane@example.co.uk',
                'phone' => '+44.1234567890',
            ]),
            'address' => new DomainRegistrantAddress([
                'line1' => '1 High Street',
                'city' => 'Stockport',
                'county' => 'Greater Manchester',
                'postcode' => 'SK1 1AA',
                'country' => 'GB',
            ]),
        ]);

        $this->assertTrue($client->updateRegistrant('example.co.uk', $registrant));
        $this->assertEquals('PUT', $this->lastRequest()->getMethod());
        $this->assertEquals('v2/domains/example.co.uk/registrant', (string) $this->lastRequest()->getUri());
        $this->assertSame([
            'type' => 'LTD',
            'company' => ['number' => '01234567', 'trading_as' => null],
            'contact' => ['name' => 'Jane Smith', 'email' => 'jane@example.co.uk', 'phone' => '+44.1234567890'],
            'address' => [
                'line1' => '1 High Street',
                'line2' => null,
                'city' => 'Stockport',
                'county' => 'Greater Manchester',
                'postcode' => 'SK1 1AA',
                'country' => 'GB',
            ],
        ], json_decode((string) $this->lastRequest()->getBody(), true));
    }
}
