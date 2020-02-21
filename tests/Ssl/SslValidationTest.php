<?php

namespace Tests\Ssl;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use UKFast\SDK\SSL\Entities\ValidationResult;
use UKFast\SDK\SSL\ValidationClient;
use Carbon\Carbon;

class SslValidationTest extends TestCase
{
    const Certificate = <<<SSLCERT
-----BEGIN CERTIFICATE-----
MIIDDTCCAfWgAwIBAgIJAN4iieq5gQNTMA0GCSqGSIb3DQEBBQUAMB0xGzAZBgNV
BAMMEnVrZmFzdC5leGFtcGxlLmNvbTAeFw0yMDAyMjExMTIwMTRaFw0zMDAyMTgx
MTIwMTRaMB0xGzAZBgNVBAMMEnVrZmFzdC5leGFtcGxlLmNvbTCCASIwDQYJKoZI
hvcNAQEBBQADggEPADCCAQoCggEBAL/zoM/nwxTdUGTrjjn5OE2ekYUW3ruBRaOb
Z/D1wXIwgZgqnT3vR37q4iDKwiXGzgYg5Wud3eSkKzoMPEH7iRQKwMO6a87FrVio
+aN0FukQhYJzEY7EwRZtxuF1dpJ3RfENR/D0ia5dkSrEn2RWKDSY2kyy4tylFexz
oU7BiupvODXjG7u631QAKzqaTkO4ZqxhpyonL3eDrsjCBDMhShcPBv/YL2I7DOBr
xHy8Q8dM2PV1Wuj0DJDFO8uFiKcA9j4eX1FJZX089GQQfGBC9E4pdwqCvMQN43gl
wck9u6fvOwxZ2Z4NGawesA0azx60Hncodk6Gs6qXkbB8z3DzsS8CAwEAAaNQME4w
HQYDVR0OBBYEFNDbkScBpjWDibauyIT/6KffqVtxMB8GA1UdIwQYMBaAFNDbkScB
pjWDibauyIT/6KffqVtxMAwGA1UdEwQFMAMBAf8wDQYJKoZIhvcNAQEFBQADggEB
AFL4JY88S9jC2dmV2eOSjeeGFKzxPg6Lo3qwIflcuVdBnh/nOl7LQK/K7UWOVs4a
VqvPE3xfGQMNoYlSE8wAS3cMOVL82iY8n06CDFpFxpVuWNPMQIJDSGBZhNd3ow9y
YKH8UdfGHQZ4891M/95Na6tq/d5FYl+2v8J1As4B//f/nFI3jlGu3jnxqE0kBsc1
R1cwEqgGoShZ7+CSLIB+3klPOmG0gveXEPWjd3un8zmWgLrgpynRdpKVCRDpBRRx
hvyujDB8MjCoBdVLpKTS8VOuBQzsoofVHeE15kqJEhQm+P8iA8l5jK8RXhbyC7R3
27Krggo+QO1bByrVEMzJFHg=
-----END CERTIFICATE-----
SSLCERT;

    const CertificateKey = <<<SSLKEY
-----BEGIN RSA PRIVATE KEY-----
MIIEogIBAAKCAQEAv/Ogz+fDFN1QZOuOOfk4TZ6RhRbeu4FFo5tn8PXBcjCBmCqd
Pe9HfuriIMrCJcbOBiDla53d5KQrOgw8QfuJFArAw7przsWtWKj5o3QW6RCFgnMR
jsTBFm3G4XV2kndF8Q1H8PSJrl2RKsSfZFYoNJjaTLLi3KUV7HOhTsGK6m84NeMb
u7rfVAArOppOQ7hmrGGnKicvd4OuyMIEMyFKFw8G/9gvYjsM4GvEfLxDx0zY9XVa
6PQMkMU7y4WIpwD2Ph5fUUllfTz0ZBB8YEL0Til3CoK8xA3jeCXByT27p+87DFnZ
ng0ZrB6wDRrPHrQedyh2ToazqpeRsHzPcPOxLwIDAQABAoIBAHISc7f6UIm+uD8x
aXV0cQxXtr00CSu/OEZxXYTqV4rn3qwybv3WjFOVfMrmFBjlG5yywgSBbdOp6HJ3
wPupYx5BAauPxu+7tDejO6/ylobtJZqPjZidvu34UR+9cbi7HxqQvPcqLAQuYM3c
yaiUNxKC4ACCsqVTikLZuLwX8tk8NYkxRuIXjRbEN9cCbQwnUVrrD1L+yZm9dxAO
QnXpnBnk/xNpHOwvtizSZO1mg6JuX7VWpgewWVWMq5yf8Pa57JdMcmlIkSMU2SZR
Ns7K4Um743fbsYdM4UCDEbDg4/ubYSqdPsG7Js8vkz5tV27/YkCJ75iuk5TvFF1a
Gl06rSECgYEA6SBo4cusiybLpMlHB8kCwyOqi0SVP6IWpmqqwjQQWDkTVjX6+Vv8
QlZ/OH6FcrUNufBqgW5ztzRde8xKwq4PFAoEYbnAtfXNiEKq0mNMM3fjuwiMNGP5
/UkFhlxAqYZPxan0tk4vZ7XpYXYS/LeJmnBkLmTkTptGOrM1rj5XmP8CgYEA0skA
XJupc4Vz5fygObeek8bkuWfyCzoE6sdlNDs1gQE6JdNIMrkHFRLPb8ACtkX7nXyd
32zGOXB6svDlkC5P45okHW74zJWMMpbKBTIObBfo2Xnrexxn2KkopO+6nkxMma/w
546B86aDpD/vGgOUR+I4K1Dc3DS1Fxi8pp1vN9ECgYAPZiWnbJW8J1biTq1TdVKq
Yyu7wU7+gg1u9rLK2zeNLE/7rNskJ5BVLXN/3tOfzRfYBWpznEEmg9389HSnwWmb
kEHT1rpFCrSF4Kl59jctWyj+zMS+HTCBK5ai1msrB4UzcFOKy0VUW27MEkmUyebb
/bqQWfe+vYD5FadhGBsfLwKBgA6tBgRspiCv8wDZVQKPwU/CslwiW5zifkMmfOpl
EPWZc0X87vLxJQgXli/Oq6GrP7iYW5mZxjdrmG9rDGC8iL1tFwShnFsKMoe3Lfus
n4pxI7o4neelc6mHJZhORK0O3Op6cIh+yJeBSXsfJHOoOiPDIWwKpkYCuXURONlU
7tBxAoGAWfWYEvKgm6zM9qzFdxr6dQIrAbvnoIoOaG3X0b4Pph+VLnW9ViS1QmQP
KGfZOHO+pWmRQ+3NezAyjQwxUtcKC9sBIvvPGtDbzgMQ4H773kr2wXxfoaLG441s
aUIekYaJh+r5OIp6f8S/wXis0U4WHk3sDz8ZGjv/bj0SUV5PjxY=
-----END RSA PRIVATE KEY-----
SSLKEY;

    protected function setUp()
    {
        parent::setUp();
    }

    /**
     * Tests ValidationResult entity class from valid response
     */
    public function testConstructsFromValidResponse()
    {
        $response = [
            'result'           => true,
            'alt_hosts'        => ["ukfast.co.uk"],
            'expiry_timestamp' => Carbon::now()->addDays(2),
        ];

        $validationClient = new ValidationClient;
        $validationResult = new ValidationResult($validationClient->apiToFriendly(
            $response,
            $validationClient->validationMap
        ));

        $this->assertEquals($response['result'], $validationResult->result);
        $this->assertEquals($response['alt_hosts'], $validationResult->altHosts);
        $this->assertEquals($response['expiry_timestamp'], $validationResult->expiryTimestamp);
    }

    /**
     * Tests ValidationResult entity class from invalid response
     */
    public function testConstructsFromInvalidResponse()
    {
        $response = [
            'result'           => false,
            'errorset'         => ["Certificate expired on 11\/02\/2020 18:00:43"],
        ];

        $validationClient = new ValidationClient;
        $validationResult = new ValidationResult($validationClient->apiToFriendly(
            $response,
            $validationClient->validationMap
        ));

        $this->assertEquals($response['result'], $validationResult->result);
        $this->assertEquals($response['errorset'], $validationResult->errorset);
    }

    /**
     * @throws \Exception
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testGetValidationResultForValidCertificate()
    {
        $validationData = (object)[
            'result'           => true,
            'alt_hosts'        => ["ukfast.co.uk"],
            'expiry_timestamp' => Carbon::now()->addDays(2),
        ];

        $mockHandler = new MockHandler([
            new Response(200, [], json_encode([
                'data' => $validationData,
                'meta' => []
            ])),
        ]);

        $handlerStack = HandlerStack::create($mockHandler);
        $httpClient   = new GuzzleClient(['handler' => $handlerStack]);

        $client           = new ValidationClient($httpClient);
        $validationResult = $client->validate(static::Certificate, static::CertificateKey, null);

        $this->assertInstanceOf(ValidationResult::class, $validationResult);
        $this->assertEquals($validationData['result'], $validationResult->result);
        $this->assertEquals($validationData['alt_hosts'], $validationResult->altHosts);
        $this->assertEquals($validationData['expiry_timestamp'], $validationResult->expiryTimestamp);
    }

    /**
     * @throws \Exception
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testGetValidationResultForInvalidCertificate()
    {
        $validationData = (object)[
            'result'           => false,
            'errorset'         => ["Certificate expired on 11\/02\/2020 18:00:43"],
        ];

        $mockHandler = new MockHandler([
            new Response(200, [], json_encode([
                'data' => $validationData,
                'meta' => []
            ])),
        ]);

        $handlerStack = HandlerStack::create($mockHandler);
        $httpClient   = new GuzzleClient(['handler' => $handlerStack]);

        $client           = new ValidationClient($httpClient);
        $validationResult = $client->validate(static::Certificate, static::CertificateKey, null);

        $this->assertInstanceOf(ValidationResult::class, $validationResult);
        $this->assertEquals($validationData['result'], $validationResult->result);
        $this->assertEquals($validationData['errorset'], $validationResult->errorset);
    }
}
