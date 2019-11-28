<?php

namespace Tests\DDoSX;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Faker\Factory as Faker;
use PHPUnit\Framework\TestCase;
use UKFast\SDK\DDoSX\DomainVerificationClient;
use UKFast\SDK\Exception\ValidationException;

class DomainVerificationTest extends TestCase
{
    protected $faker;

    protected function setUp()
    {
        parent::setUp();

        $this->faker = Faker::create();
    }


    /**
     * @test
     */
    public function verify_domain_via_dns()
    {
        $mock = new MockHandler([
            new Response(200),
            new Response(422),
        ]);

        $guzzle = new Client(['handler' => HandlerStack::create($mock)]);
        $client = new DomainVerificationClient($guzzle);

        $this->assertTrue($client->verifyByDns($this->faker->domainName));

        $this->expectException(ValidationException::class);
        $client->verifyByDns($this->faker->domainName);
    }

    /**
     * @test
     */
    public function verify_domain_via_file_upload()
    {
        $mock = new MockHandler([
            new Response(200),
            new Response(422),
        ]);

        $guzzle = new Client(['handler' => HandlerStack::create($mock)]);
        $client = new DomainVerificationClient($guzzle);

        $this->assertTrue($client->verifyByDns($this->faker->domainName));

        $this->expectException(ValidationException::class);
        $client->verifyByDns($this->faker->domainName);
    }

    /**
     * @test
     */
    public function download_verification_file()
    {
        $filename           = $this->faker->word . '.txt';
        $verificationString = $this->faker->word . PHP_EOL . $this->faker->word;

        $mock = new MockHandler([
            new Response(200, ['Content-Disposition' => 'attachment; filename="'. $filename . '"'], $verificationString),
        ]);

        $guzzle = new Client(['handler' => HandlerStack::create($mock)]);
        $client = new DomainVerificationClient($guzzle);

        $verificationFile = $client->getVerificationFile($this->faker->domainName);

        $this->assertEquals($filename, $verificationFile->getName());
        $this->assertEquals($verificationString, $verificationFile->getStream()->getContents());
    }
}
