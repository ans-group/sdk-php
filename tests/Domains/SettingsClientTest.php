<?php

namespace Tests\Domains;

use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use UKFast\SDK\Domains\Entities\Settings;
use UKFast\SDK\Domains\SettingsClient;

class SettingsClientTest extends TestCase
{
    /**
     * @var array
     */
    private $history = [];

    /**
     * @param Response[] $responses
     * @return SettingsClient
     */
    private function client($responses)
    {
        $this->history = [];
        $handler = HandlerStack::create(new MockHandler($responses));
        $handler->push(Middleware::history($this->history));

        return new SettingsClient(new Guzzle(['handler' => $handler]));
    }

    /**
     * @return \Psr\Http\Message\RequestInterface
     */
    private function lastRequest()
    {
        return end($this->history)['request'];
    }

    public function testGetSettingsReadsNameserversAndRenewal()
    {
        $client = $this->client([
            new Response(200, [], json_encode([
                'data' => [
                    'registration' => [
                        'nameserver_one' => 'ns0.ukfast.net',
                        'nameserver_two' => 'ns1.ukfast.net',
                        'nameserver_three' => null,
                    ],
                    'renewal' => ['auto' => true, 'auto_term' => 1],
                ],
                'meta' => [],
            ])),
        ]);

        $settings = $client->getSettings();

        $this->assertEquals('GET', $this->lastRequest()->getMethod());
        $this->assertEquals('v2/settings', (string) $this->lastRequest()->getUri());
        $this->assertInstanceOf(Settings::class, $settings);
        $this->assertEquals('ns0.ukfast.net', $settings->nameserverOne);
        $this->assertEquals('ns1.ukfast.net', $settings->nameserverTwo);
        $this->assertNull($settings->nameserverThree);
        $this->assertTrue($settings->autoRenew);
        $this->assertEquals(1, $settings->autoRenewTerm);
    }

    public function testUpdateSendsEverySettingThatIsSet()
    {
        $client = $this->client([new Response(200, [], json_encode(['data' => [], 'meta' => []]))]);

        $this->assertTrue($client->update(new Settings([
            'nameserverOne' => 'ns0.ukfast.net',
            'nameserverTwo' => 'ns1.ukfast.net',
            'nameserverThree' => null,
            'autoRenew' => false,
            'autoRenewTerm' => 2,
        ])));

        $this->assertEquals('PATCH', $this->lastRequest()->getMethod());
        $this->assertEquals('v2/settings', (string) $this->lastRequest()->getUri());
        $this->assertSame([
            'registration' => [
                'nameserver_one' => 'ns0.ukfast.net',
                'nameserver_two' => 'ns1.ukfast.net',
                'nameserver_three' => null,
            ],
            'renewal' => ['auto' => false, 'auto_term' => 2],
        ], json_decode((string) $this->lastRequest()->getBody(), true));
    }

    public function testUpdateLeavesOutSettingsThatAreNotSet()
    {
        $client = $this->client([new Response(200, [], json_encode(['data' => [], 'meta' => []]))]);

        $client->update(new Settings(['autoRenewTerm' => 3]));

        $this->assertSame(
            ['renewal' => ['auto_term' => 3]],
            json_decode((string) $this->lastRequest()->getBody(), true)
        );
    }
}
