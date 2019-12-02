<?php

namespace Tests\Ltaas;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use UKFast\SDK\LTaaS\Entities\Account;

class AccountTest extends TestCase
{
    /**
     * @test
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function create_a_new_user()
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode([
                'data' => [
                    'id' => 'c25606b7-bfbd-41d1-aff1-1f66ea1892c6',
                ],
                'meta' => [
                    'location' => ''
                ]
            ]))
        ]);

        $handler = HandlerStack::create($mock);
        $guzzle = new \GuzzleHttp\Client(['handler' => $handler]);

        $client = new \UKFast\SDK\LTaaS\Client($guzzle);
        $account = $client->accounts()->create(new Account());

        $this->assertTrue($account instanceof \UKFast\SDK\SelfResponse);
    }
}
