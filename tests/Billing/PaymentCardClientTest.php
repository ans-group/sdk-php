<?php

namespace Tests\Billing;

use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use DateTime;
use UKFast\SDK\Billing\Entities\PaymentCard;

class PaymentCardClientTest extends TestCase
{
    /**
     * @test
     */
    public function get_payment_cards_by_id()
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode([
                'data' => [
                    "id" => 1,
                    "friendly_name" => "Test Card",
                    "name" => "TW",
                    "address" => "Test Street",
                    "postcode" => "M44 0AB",
                    "card_number" => "4111111111111111",
                    "card_type" => "Visa",
                    "valid_from" => "2019-10-31T00:00:00+0000",
                    "expiry" => "2035-10-31T00:00:00+0000",
                    "issue_number" => 12,
                    "primary_card" => true
                ],
                'meta' => []
            ])),
        ]);

        $handler = HandlerStack::create($mock);
        $guzzle = new Guzzle(['handler' => $handler]);

        $client = new \UKFast\SDK\Billing\Client($guzzle);
        $paymentCard = $client->paymentCards()->getById(1);

        $this->assertTrue($paymentCard instanceof PaymentCard);
        $this->assertEquals(1, $paymentCard->id);
        $this->assertEquals("Test Card", $paymentCard->friendlyName);
        $this->assertEquals("TW", $paymentCard->name);
        $this->assertEquals("Test Street", $paymentCard->address);
        $this->assertEquals("M44 0AB", $paymentCard->postcode);
        $this->assertEquals("4111111111111111", $paymentCard->cardNumber);
        $this->assertEquals("Visa", $paymentCard->cardType);
        $this->assertEquals('2019-10-31T00:00:00+0000', $paymentCard->validFrom->format(DateTime::ISO8601));
        $this->assertEquals('2035-10-31T00:00:00+0000', $paymentCard->expiry->format(DateTime::ISO8601));
        $this->assertEquals(12, $paymentCard->issueNumber);
        $this->assertTrue(true, $paymentCard->primaryCard);

        $this->assertInternalType('int', $paymentCard->id);
        $this->assertInternalType('int', $paymentCard->issueNumber);
    }

    /**
     * @test
     */
    public function get_payment_cards()
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode([
                'data' => [
                    [
                        "id" => 1,
                        "friendly_name" => "Test Card",
                        "name" => "TW",
                        "address" => "Test Street",
                        "postcode" => "M44 0AB",
                        "card_number" => "4111111111111111",
                        "card_type" => "Visa",
                        "valid_from" => "2019-10-31T00:00:00+0000",
                        "expiry" => "2035-10-31T00:00:00+0000",
                        "issue_number" => 12,
                        "primary_card" => true
                    ],
                    [
                        "id" => 2,
                        "friendly_name" => "Test Mastercard",
                        "name" => "TW",
                        "address" => "Test Street",
                        "postcode" => "M44 0AB",
                        "card_number" => "5355 1234 5678 9012",
                        "card_type" => "Mastercard",
                        "valid_from" => null,
                        "expiry" => "2035-10-31T00:00:00+0000",
                        "issue_number" => null,
                        "primary_card" => false
                    ],
                ],
                'meta' => [
                    'pagination' => [
                        'total' => 2,
                        'per_page' => 2,
                        'total_pages' => 1,
                        'links' => [
                            'next' => 'http://example.com/next',
                            'previous' => 'http://example.com/previous',
                            'first' => 'http://example.com/first',
                            'last' => 'http://example.com/last',
                        ]
                    ]
                ]
            ])),
        ]);

        $handler = HandlerStack::create($mock);
        $guzzle = new Guzzle(['handler' => $handler]);

        $client = new \UKFast\SDK\Billing\Client($guzzle);
        $paymentCards = $client->paymentCards()->getPage();
        $items = $paymentCards->getItems();

        $this->assertEquals(2, count($items));
        $this->assertTrue($items[0] instanceof PaymentCard);
        $this->assertTrue($items[1] instanceof PaymentCard);
    }

    /**
     * @test
     */
    public function create_payment_card()
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode([
                'data' => [
                    "id" => 1
                ],
                'meta' => [
                    "location" => "http://example.com/billing/v1/cards/1"
                ]
            ])),
        ]);

        $handler = HandlerStack::create($mock);
        $guzzle = new Guzzle(['handler' => $handler]);

        $client = new \UKFast\SDK\Billing\Client($guzzle);
        $paymentCard = $client->paymentCards()->create([]);

        $this->assertEquals(1, $paymentCard->getId());
        $this->assertEquals("http://example.com/billing/v1/cards/1", $paymentCard->getLocation());
    }

    /**
     * @test
     */
    public function update_payment_card()
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode([
                'data' => [
                    "id" => 1
                ],
                'meta' => [
                    "location" => "http://example.com/billing/v1/cards/1"
                ]
            ])),
        ]);

        $handler = HandlerStack::create($mock);
        $guzzle = new Guzzle(['handler' => $handler]);

        $client = new \UKFast\SDK\Billing\Client($guzzle);
        $paymentCard = $client->paymentCards()->update(1, []);

        $this->assertEquals(1, $paymentCard->getId());
        $this->assertEquals("http://example.com/billing/v1/cards/1", $paymentCard->getLocation());
    }

    /**
     * @test
     */
    public function destroy_payment_card()
    {
        $mock = new MockHandler([
            new Response(204, []),
        ]);

        $handler = HandlerStack::create($mock);
        $guzzle = new Guzzle(['handler' => $handler]);

        $client = new \UKFast\SDK\Billing\Client($guzzle);
        $paymentCard = $client->paymentCards()->destroy(1);

        $this->assertNull($paymentCard);
    }
}
