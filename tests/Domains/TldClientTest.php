<?php

namespace Tests\Domains;

use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use UKFast\SDK\Domains\Entities\Tld;
use UKFast\SDK\Domains\TldClient;

class TldClientTest extends TestCase
{
    private function page($names, $page, $totalPages)
    {
        return new Response(200, [], json_encode([
            'data' => array_map(function ($name) {
                return ['name' => $name];
            }, $names),
            'meta' => ['pagination' => [
                'total' => 3,
                'count' => count($names),
                'per_page' => 100,
                'current_page' => $page,
                'total_pages' => $totalPages,
            ]],
        ]));
    }

    public function testGetAllListsEveryPageOfTlds()
    {
        $history = [];
        $handler = HandlerStack::create(new MockHandler([
            $this->page(['.com', '.co.uk'], 1, 2),
            $this->page(['.uk'], 2, 2),
        ]));
        $handler->push(Middleware::history($history));
        $client = new TldClient(new Guzzle(['handler' => $handler]));

        $tlds = $client->getAll();

        $this->assertCount(2, $history);
        $this->assertStringStartsWith('v2/tlds?', (string) $history[0]['request']->getUri());
        $this->assertNotFalse(strpos((string) $history[1]['request']->getUri(), 'page=2'));
        $this->assertCount(3, $tlds);
        $this->assertInstanceOf(Tld::class, $tlds[0]);
        $this->assertEquals(['.com', '.co.uk', '.uk'], array_map(function ($tld) {
            return $tld->name;
        }, $tlds));
    }

    public function testLoadEntityMapsEveryTldField()
    {
        // A live v2/tlds item.
        $tld = (new TldClient())->loadEntity(json_decode(json_encode([
            'name' => '.academy',
            'description' => 'Perfect for schools, educational institutes, students and teachers',
            'category' => ['name' => 'Education and Professional', 'order' => 4],
            'registration' => [
                'realtime' => true,
                'requirements' => null,
                'validation' => true,
                'irtp' => true,
                'min_term' => 1,
            ],
            'renewal' => ['auto' => false, 'min_term' => 1, 'milestone' => 0],
            'transfer' => ['min_term' => 1],
            'privacy' => ['available' => true, 'fee' => false],
            'created_at' => '2014-03-19T12:24:21+00:00',
            'updated_at' => '2014-03-19T12:24:21+00:00',
        ])));

        $this->assertEquals('.academy', $tld->name);
        $this->assertEquals('Perfect for schools, educational institutes, students and teachers', $tld->description);
        $this->assertEquals('Education and Professional', $tld->categoryName);
        $this->assertEquals(4, $tld->categoryOrder);
        $this->assertTrue($tld->registrationRealtime);
        $this->assertNull($tld->registrationRequirements);
        $this->assertTrue($tld->registrationValidation);
        $this->assertTrue($tld->registrationIrtp);
        $this->assertEquals(1, $tld->registrationMinTerm);
        $this->assertFalse($tld->renewalAuto);
        $this->assertEquals(1, $tld->renewalMinTerm);
        $this->assertEquals(0, $tld->renewalMilestone);
        $this->assertEquals(1, $tld->transferMinTerm);
        $this->assertTrue($tld->privacyAvailable);
        $this->assertFalse($tld->privacyFee);
        $this->assertEquals('2014-03-19T12:24:21+00:00', $tld->createdAt);
        $this->assertEquals('2014-03-19T12:24:21+00:00', $tld->updatedAt);
    }

    public function testLoadEntityCopesWithMissingSections()
    {
        $tld = (new TldClient())->loadEntity((object) ['name' => '.com']);

        $this->assertEquals('.com', $tld->name);
        $this->assertNull($tld->categoryName);
        $this->assertNull($tld->renewalMilestone);
    }
}
