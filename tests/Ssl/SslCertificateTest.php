<?php

namespace Tests\Ssl;

use DateTime;
use Faker\Factory as Faker;
use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use UKFast\SDK\SSL\CertificateClient;
use UKFast\SDK\SSL\Entities\Certificate;

class SslCertificateTest extends TestCase
{
    /**
     * @var Faker $faker
     */
    protected $faker;

    protected function setFaker()
    {
        $this->faker = Faker::create();
    }

    /**
     * @test
     * @throws \Exception
     */
    public function constructs_from_response()
    {
        $this->setFaker();

        $validDays = $this->faker->numberBetween(1, 825);

        $response = [
            'id'                => $this->faker->randomDigitNotNull,
            'name'              => $this->faker->word,
            'status'            => $this->faker->word,
            'common_name'       => $this->faker->domainName,
            'alternative_names' => [
                $this->faker->domainName,
                $this->faker->domainName,
            ],
            'valid_days'        => $validDays,
            'ordered_date'      => (new DateTime('-' . (825 - $validDays) . ' days'))->format(DateTime::ATOM),
            'renewal_date'      => (new DateTime('+' . $validDays . ' days'))->format(DateTime::ATOM),
        ];

        $certificateClient = new CertificateClient;

        $certificate = new Certificate($certificateClient->apiToFriendly(
            $response,
            $certificateClient->certificateMap
        ));

        $this->assertEquals($response['id'], $certificate->id);
        $this->assertEquals($response['name'], $certificate->name);
        $this->assertEquals($response['status'], $certificate->status);
        $this->assertEquals($response['common_name'], $certificate->commonName);
        $this->assertEquals($response['alternative_names'], $certificate->alternativeNames);
        $this->assertEquals($response['valid_days'], $certificate->validDays);
        $this->assertEquals(DateTime::createFromFormat(DateTime::ATOM, $response['ordered_date']), $certificate->orderedAt);
        $this->assertEquals(DateTime::createFromFormat(DateTime::ATOM, $response['renewal_date']), $certificate->renewalAt);
    }

    /**
     * @test
     * @throws \Exception
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function gets_certificates_page()
    {
        $this->setFaker();

        $validDaysOne = $this->faker->numberBetween(1, 825);
        $validDaysTwo = $this->faker->numberBetween(1, 825);

        $mockHandler = new MockHandler([
            new Response(200, [], json_encode([
                'data' => [
                    [
                        'id'                => $this->faker->randomDigitNotNull,
                        'name'              => $this->faker->word,
                        'status'            => $this->faker->word,
                        'common_name'       => $this->faker->domainName,
                        'alternative_names' => [
                            $this->faker->domainName,
                            $this->faker->domainName,
                        ],
                        'valid_days'        => $validDaysOne,
                        'ordered_date'      => (new DateTime('-' . (825 - $validDaysOne) . ' days'))->format(DateTime::ATOM),
                        'renewal_date'      => (new DateTime('+' . $validDaysOne . ' days'))->format(DateTime::ATOM),
                    ],
                    [
                        'id'                => $this->faker->randomDigitNotNull,
                        'name'              => $this->faker->word,
                        'status'            => $this->faker->word,
                        'common_name'       => $this->faker->domainName,
                        'alternative_names' => [
                            $this->faker->domainName,
                            $this->faker->domainName,
                        ],
                        'valid_days'        => $validDaysTwo,
                        'ordered_date'      => (new DateTime('-' . (825 - $validDaysTwo) . ' days'))->format(DateTime::ATOM),
                        'renewal_date'      => (new DateTime('+' . $validDaysTwo . ' days'))->format(DateTime::ATOM),
                    ],
                ],
                'meta' => [
                    'pagination' => [
                        'total'       => 2,
                        'per_page'    => 2,
                        'total_pages' => 1,
                        'links'       => [
                            'next'     => 'http://example.com/next',
                            'previous' => 'http://example.com/previous',
                            'first'    => 'http://example.com/first',
                            'last'     => 'http://example.com/last',
                        ]
                    ]
                ]
            ])),
        ]);

        $handlerStack = HandlerStack::create($mockHandler);
        $httpClient   = new Guzzle(['handler' => $handlerStack]);

        $client          = new CertificateClient($httpClient);
        $certificatePage = $client->getPage();
        $certificates    = $certificatePage->getItems();

        $this->assertEquals(2, count($certificates));
        $this->assertInstanceOf(Certificate::class, $certificates[0]);
        $this->assertInstanceOf(Certificate::class, $certificates[1]);
    }

    /**
     * @test
     * @throws \Exception
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function gets_certificate_by_id()
    {
        $this->setFaker();
        
        $validDays = $this->faker->numberBetween(1, 825);

        $mockHandler = new MockHandler([
            new Response(200, [], json_encode([
            'data' => [
                    'id'                => $this->faker->randomDigitNotNull,
                    'name'              => $this->faker->word,
                    'status'            => $this->faker->word,
                    'common_name'       => $this->faker->domainName,
                    'alternative_names' => [
                        $this->faker->domainName,
                        $this->faker->domainName,
                    ],
                    'valid_days'        => $validDays,
                    'ordered_date'      => (new DateTime('-' . (825 - $validDays) . ' days'))->format(DateTime::ATOM),
                    'renewal_date'      => (new DateTime('+' . $validDays . ' days'))->format(DateTime::ATOM),
                ],
                'meta' => []
            ])),
        ]);

        $handlerStack = HandlerStack::create($mockHandler);
        $httpClient   = new Guzzle(['handler' => $handlerStack]);

        $client      = new CertificateClient($httpClient);
        $certificate = $client->getById(1);

        $this->assertInstanceOf(Certificate::class, $certificate);
    }
}
