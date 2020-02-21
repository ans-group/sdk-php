<?php

namespace Tests\Ssl;

use DateTime;
use Faker\Factory as Faker;
use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use UKFast\SDK\SSL\Entities\Certificate;
use UKFast\SDK\SSL\ValidationClient;
use Carbon\Carbon;

class SslValidationTest extends TestCase
{
    /**
     * @var Faker $faker
     */
    protected $faker;

    protected function setUp()
    {
        parent::setUp();

        $this->faker = Faker::create();
    }

    /**
     * Tests ValidationResult entity class
     */
    public function testConstructsFromValidResponse()
    {
        $response = [
            'result'           => true,
            'alt_hosts'        => ["ukfast.co.uk"],
            'expiry_timestamp' => Carbon::now()->addDays(2),
        ];

        $validationClient = new ValidationClient;

        $validationResult = new Certificate($validationClient->apiToFriendly(
            $response,
            $validationClient->certificateMap
        ));

        $this->assertEquals($response['result'], $validationResult->id);
        $this->assertEquals($response['alt_hosts'], $validationResult->altHosts);
        $this->assertEquals($response['expiry_timestamp'], $validationResult->expiryTimestamp);
    }
//
//    /**
//     * @test
//     * @throws \Exception
//     * @throws \GuzzleHttp\Exception\GuzzleException
//     */
//    public function gets_certificates_page()
//    {
//        $validDaysOne = $this->faker->numberBetween(1, 825);
//        $validDaysTwo = $this->faker->numberBetween(1, 825);
//
//        $mockHandler = new MockHandler([
//            new Response(200, [], json_encode([
//                'data' => [
//                    [
//                        'id'                => $this->faker->randomDigitNotNull,
//                        'name'              => $this->faker->word,
//                        'status'            => $this->faker->word,
//                        'common_name'       => $this->faker->domainName,
//                        'alternative_names' => [
//                            $this->faker->domainName,
//                            $this->faker->domainName,
//                        ],
//                        'valid_days'        => $validDaysOne,
//                        'ordered_date'      => (new DateTime('-' . (825 - $validDaysOne) . ' days'))->format(DateTime::ATOM),
//                        'renewal_date'      => (new DateTime('+' . $validDaysOne . ' days'))->format(DateTime::ATOM),
//                    ],
//                    [
//                        'id'                => $this->faker->randomDigitNotNull,
//                        'name'              => $this->faker->word,
//                        'status'            => $this->faker->word,
//                        'common_name'       => $this->faker->domainName,
//                        'alternative_names' => [
//                            $this->faker->domainName,
//                            $this->faker->domainName,
//                        ],
//                        'valid_days'        => $validDaysTwo,
//                        'ordered_date'      => (new DateTime('-' . (825 - $validDaysTwo) . ' days'))->format(DateTime::ATOM),
//                        'renewal_date'      => (new DateTime('+' . $validDaysTwo . ' days'))->format(DateTime::ATOM),
//                    ],
//                ],
//                'meta' => [
//                    'pagination' => [
//                        'total'       => 2,
//                        'per_page'    => 2,
//                        'total_pages' => 1,
//                        'links'       => [
//                            'next'     => 'http://example.com/next',
//                            'previous' => 'http://example.com/previous',
//                            'first'    => 'http://example.com/first',
//                            'last'     => 'http://example.com/last',
//                        ]
//                    ]
//                ]
//            ])),
//        ]);
//
//        $handlerStack = HandlerStack::create($mockHandler);
//        $httpClient   = new Guzzle(['handler' => $handlerStack]);
//
//        $client          = new CertificateClient($httpClient);
//        $certificatePage = $client->getPage();
//        $certificates    = $certificatePage->getItems();
//
//        $this->assertEquals(2, count($certificates));
//        $this->assertInstanceOf(Certificate::class, $certificates[0]);
//        $this->assertInstanceOf(Certificate::class, $certificates[1]);
//    }
//
//    /**
//     * @test
//     * @throws \Exception
//     * @throws \GuzzleHttp\Exception\GuzzleException
//     */
//    public function gets_certificate_by_id()
//    {
//        $validDays = $this->faker->numberBetween(1, 825);
//
//        $mockHandler = new MockHandler([
//            new Response(200, [], json_encode([
//            'data' => [
//                    'id'                => $this->faker->randomDigitNotNull,
//                    'name'              => $this->faker->word,
//                    'status'            => $this->faker->word,
//                    'common_name'       => $this->faker->domainName,
//                    'alternative_names' => [
//                        $this->faker->domainName,
//                        $this->faker->domainName,
//                    ],
//                    'valid_days'        => $validDays,
//                    'ordered_date'      => (new DateTime('-' . (825 - $validDays) . ' days'))->format(DateTime::ATOM),
//                    'renewal_date'      => (new DateTime('+' . $validDays . ' days'))->format(DateTime::ATOM),
//                ],
//                'meta' => []
//            ])),
//        ]);
//
//        $handlerStack = HandlerStack::create($mockHandler);
//        $httpClient   = new Guzzle(['handler' => $handlerStack]);
//
//        $client      = new CertificateClient($httpClient);
//        $certificate = $client->getById(1);
//
//        $this->assertInstanceOf(Certificate::class, $certificate);
//    }
}
