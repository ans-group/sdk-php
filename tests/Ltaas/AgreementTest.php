<?php

namespace Tests\Ltaas;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class AgreementTest extends TestCase
{
    /**
     * @test
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function valid_agreement_request()
    {
        $agreementHtml = '<p><<<COMPANY_NAME>>> grants permission to UKFast.Net Limited (“UKFast”) to perform 
                        load testing as set out below</p><p><strong>Schedule of Test / Domain Details</strong></p>
                        <p><strong>Test target:</strong> <<<TARGET>>></p>';

        $mock = new MockHandler([
            new Response(200, [], json_encode([
                'data' => [
                    'version' => 'v1.0',
                    'agreement' => $agreementHtml
                ],
                'meta' => []
            ]))
        ]);

        $handler = HandlerStack::create($mock);
        $guzzle = new \GuzzleHttp\Client(['handler' => $handler]);

        $client = new \UKFast\SDK\LTaaS\Client($guzzle);
        $agreement = $client->agreements()->latestByType('single');

        $this->assertTrue($agreement instanceof \UKFast\SDK\LTaaS\Entities\Agreement);
        $this->assertEquals('v1.0', $agreement->version);
        $this->assertEquals($agreementHtml, $agreement->agreement);
    }
}
