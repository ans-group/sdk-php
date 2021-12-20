<?php

namespace Tests\DDoSX;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use UKFast\SDK\DDoSX\DomainVerificationClient;
use UKFast\SDK\Exception\ValidationException;

class DomainVerificationTest extends TestCase
{
    /**
     * @test
     */
    public function verify_domain_via_dns()
    {
        $domainName = 'example.com';
        $mock       = new MockHandler([
            new Response(200),
            new Response(422, [], json_encode([
                'errors' => [
                    'title' => '"Verification Failed',
                    'detail' => 'We were unable to verify ' . $domainName,
                    'status' => 422,
                    'source' => 'domain_name'
                ]
            ])),
        ]);

        $guzzle = new Client(['handler' => HandlerStack::create($mock)]);
        $client = new DomainVerificationClient($guzzle);

        $this->assertTrue($client->verifyByDns($domainName));

        $this->expectException(ValidationException::class);
        $client->verifyByDns('example.com');
    }

    /**
     * @test
     */
    public function verify_domain_via_file_upload()
    {
        $domainName = 'example.com';
        $mock       = new MockHandler([
            new Response(200),
            new Response(422, [], json_encode([
                'errors' => [
                    'title' => '"Verification Failed',
                    'detail' => 'We were unable to verify ' . $domainName,
                    'status' => 422,
                    'source' => 'domain_name'
                ]
            ])),
        ]);

        $guzzle = new Client(['handler' => HandlerStack::create($mock)]);
        $client = new DomainVerificationClient($guzzle);

        $this->assertTrue($client->verifyByDns($domainName));

        $this->expectException(ValidationException::class);
        $client->verifyByDns('example.com');
    }

    /**
     * @test
     */
    public function download_verification_file()
    {
        $filename           = 'test.txt';
        $verificationString = 'test1' . PHP_EOL . 'test2';
        $contentType        = 'text/plain; charset=UTF-8';

        $mock = new MockHandler([
            new Response(200, [
                'Content-Disposition' => 'attachment; filename="'. $filename . '"',
                'Content-Type'        => $contentType,
            ], $verificationString),
        ]);

        $guzzle = new Client(['handler' => HandlerStack::create($mock)]);
        $client = new DomainVerificationClient($guzzle);

        $verificationFile = $client->getVerificationFile('example.com');

        $this->assertEquals($filename, $verificationFile->getName());
        $this->assertEquals($verificationString, $verificationFile->getStream()->getContents());
        $this->assertEquals($contentType, $verificationFile->getContentType());
    }
}
