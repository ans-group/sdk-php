<?php

namespace Tests\Domains;

use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use UKFast\SDK\Domains\DomainRegistrationClient;
use UKFast\SDK\Domains\Entities\DomainAvailability;
use UKFast\SDK\Domains\Entities\DomainAvailabilityTerm;
use UKFast\SDK\Domains\Entities\DomainRegistrant;
use UKFast\SDK\Domains\Entities\DomainRegistrantAddress;
use UKFast\SDK\Domains\Entities\DomainRegistrantContact;
use UKFast\SDK\Domains\Entities\DomainRegistration;
use UKFast\SDK\Domains\Entities\DomainRenewal;
use UKFast\SDK\SelfResponse;

class DomainRegistrationClientTest extends TestCase
{
    public function testCheckAvailabilityReturnsDomainAvailabilityEntity()
    {
        $data = [
            'domain' => 'amazon.co.uk',
            'available' => false,
            'terms' => [
                ['period' => 1, 'price' => '6.30'],
                ['period' => 2, 'price' => '11.27'],
            ],
        ];

        $mock = new MockHandler([
            new Response(200, [], json_encode(['data' => $data, 'meta' => []]))
        ]);
        $client = new DomainRegistrationClient(new Guzzle(['handler' => HandlerStack::create($mock)]));

        $result = $client->checkAvailability('amazon.co.uk');

        $this->assertInstanceOf(DomainAvailability::class, $result);
        $this->assertEquals('amazon.co.uk', $result->domain);
        $this->assertFalse($result->available);
        $this->assertCount(2, $result->terms);
        $this->assertInstanceOf(DomainAvailabilityTerm::class, $result->terms[0]);
        $this->assertEquals(1, $result->terms[0]->period);
        $this->assertEquals('6.30', $result->terms[0]->price);
        $this->assertEquals(2, $result->terms[1]->period);
        $this->assertEquals('11.27', $result->terms[1]->price);
    }

    public function testRegisterReturnsSelfResponse()
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode([
                'data' => ['name' => 'example.co.uk'],
                'meta' => ['location' => 'https://api.ukfast.io/registrar/v2/domains/example.co.uk'],
            ])),
        ]);
        $client = new DomainRegistrationClient(new Guzzle(['handler' => HandlerStack::create($mock)]));

        $registration = new DomainRegistration([
            'name' => 'example.co.uk',
            'period' => 1,
        ]);

        $result = $client->register($registration);

        $this->assertInstanceOf(SelfResponse::class, $result);
        $this->assertEquals('example.co.uk', $result->getId());
        $this->assertEquals(
            'https://api.ukfast.io/registrar/v2/domains/example.co.uk',
            $result->getLocation()
        );
    }

    public function testToApiArrayOmitsNullValues()
    {
        $registration = new DomainRegistration([
            'name' => 'example.co.uk',
            'period' => 2,
        ]);

        $api = $registration->toApiArray();

        $this->assertEquals(['name' => 'example.co.uk', 'period' => 2], $api);
        $this->assertArrayNotHasKey('nameservers', $api);
        $this->assertArrayNotHasKey('renewal', $api);
        $this->assertArrayNotHasKey('registrant', $api);
        $this->assertArrayNotHasKey('client', $api);
    }

    public function testToApiArraySerializesClientId()
    {
        $registration = new DomainRegistration([
            'name' => 'example.co.uk',
            'period' => 1,
            'clientId' => 18638,
        ]);

        $api = $registration->toApiArray();

        $this->assertEquals(['id' => 18638], $api['client']);
    }

    public function testToApiArraySerializesNominetRegistrant()
    {
        $registrant = new DomainRegistrant([
            'nominetId' => 'UK12345',
        ]);

        $registration = new DomainRegistration([
            'name' => 'example.co.uk',
            'period' => 1,
            'registrant' => $registrant,
        ]);

        $api = $registration->toApiArray();

        $this->assertEquals('UK12345', $api['registrant']['nominet_id']);
        $this->assertArrayNotHasKey('contact', $api['registrant']);
        $this->assertArrayNotHasKey('address', $api['registrant']);
    }

    public function testToApiArraySerializesOpenSrsRegistrant()
    {
        $contact = new DomainRegistrantContact([
            'name' => 'John Smith',
            'email' => 'john@example.com',
            'phone' => '+44.1234567890',
        ]);
        $address = new DomainRegistrantAddress([
            'line1' => '123 Test Street',
            'city' => 'Manchester',
            'county' => 'Greater Manchester',
            'postcode' => 'M1 1AA',
            'country' => 'GB',
        ]);
        $registrant = new DomainRegistrant([
            'contact' => $contact,
            'address' => $address,
        ]);

        $registration = new DomainRegistration([
            'name' => 'example.com',
            'period' => 1,
            'autoRenew' => true,
            'registrant' => $registrant,
        ]);

        $api = $registration->toApiArray();

        $this->assertEquals(['auto' => true], $api['renewal']);
        $this->assertEquals('John Smith', $api['registrant']['contact']['name']);
        $this->assertEquals('john@example.com', $api['registrant']['contact']['email']);
        $this->assertEquals('+44.1234567890', $api['registrant']['contact']['phone']);
        $this->assertEquals('123 Test Street', $api['registrant']['address']['line1']);
        $this->assertEquals('GB', $api['registrant']['address']['country']);
        $this->assertArrayNotHasKey('line2', $api['registrant']['address']);
    }

    public function testGetRenewalReturnsTheRenewalTerms()
    {
        $history = [];
        $handler = HandlerStack::create(new MockHandler([
            new Response(200, [], json_encode([
                'data' => [
                    'available' => true,
                    'terms' => [
                        ['period' => 1, 'price' => '36.75'],
                        ['period' => 2, 'price' => '72.57'],
                    ],
                ],
                'meta' => [],
            ])),
        ]));
        $handler->push(Middleware::history($history));
        $client = new DomainRegistrationClient(new Guzzle(['handler' => $handler]));

        $renewal = $client->getRenewal('edgeley.community');

        $this->assertEquals('GET', $history[0]['request']->getMethod());
        $this->assertEquals('v2/domains/edgeley.community/renewal', (string) $history[0]['request']->getUri());
        $this->assertInstanceOf(DomainRenewal::class, $renewal);
        $this->assertTrue($renewal->available);
        $this->assertCount(2, $renewal->terms);
        $this->assertInstanceOf(DomainAvailabilityTerm::class, $renewal->terms[0]);
        $this->assertEquals(1, $renewal->terms[0]->period);
        $this->assertSame('36.75', $renewal->terms[0]->price);
    }

    public function testRenewSendsThePeriodAndTheQuotedPrice()
    {
        $history = [];
        $handler = HandlerStack::create(new MockHandler([
            new Response(200, [], json_encode(['data' => ['id' => 'edgeley.community'], 'meta' => []])),
        ]));
        $handler->push(Middleware::history($history));
        $client = new DomainRegistrationClient(new Guzzle(['handler' => $handler]));

        $this->assertTrue($client->renew('edgeley.community', 1, '36.75'));
        $this->assertEquals('POST', $history[0]['request']->getMethod());
        $this->assertEquals('v2/domains/edgeley.community/renewal', (string) $history[0]['request']->getUri());
        $this->assertSame(
            ['period' => 1, 'price' => '36.75'],
            json_decode((string) $history[0]['request']->getBody(), true)
        );
    }
}
