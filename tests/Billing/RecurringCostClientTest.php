<?php

namespace Tests\Billing;

use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use UKFast\SDK\Billing\Entities\Product;
use UKFast\SDK\Billing\Entities\RecurringCost;
use DateTime;

class RecurringCostClientTest extends TestCase
{
    /**
     * @test
     */
    public function get_recurring_cost_by_id()
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode([
                'data' => [
                    'id' => 123,
                    'reference_id' => 782,
                    'reference_name' => 'Example recurring cost',
                    'product' => [
                        "id" => 1,
                        'name' => ""
                    ],
                    'total' => 12.50,
                    'period' => 'month',
                    'interval' => 1,
                    'payment_method' => 'On Account',
                    'next_payment_at' => '2019-12-01',
                    'created_at' => '2016-06-07T16:29:06+0000'
                ],
                'meta' => []
            ])),
        ]);

        $handler = HandlerStack::create($mock);
        $guzzle = new Guzzle(['handler' => $handler]);

        $client = new \UKFast\SDK\Billing\Client($guzzle);
        $recurringCost = $client->recurringCosts()->getById(123);

        $this->assertTrue($recurringCost instanceof RecurringCost);
        $this->assertEquals(123, $recurringCost->id);
        $this->assertEquals(782, $recurringCost->type->id);
        $this->assertEquals('Example recurring cost', $recurringCost->type->name);
        $this->assertEquals(1, $recurringCost->product->id);
        $this->assertEquals("", $recurringCost->product->name);
        $this->assertEquals(12.50, $recurringCost->total);
        $this->assertEquals('month', $recurringCost->period);
        $this->assertEquals(1, $recurringCost->interval);
        $this->assertEquals('On Account', $recurringCost->paymentMethod);
        $this->assertEquals('2019-12-01', $recurringCost->nextPaymentAt->format('Y-m-d'));
        $this->assertEquals('2016-06-07T16:29:06+0000', $recurringCost->createdAt->format(DateTime::ISO8601));

        $this->assertInternalType('int', $recurringCost->id);
        $this->assertInternalType('float', $recurringCost->total);
        $this->assertInternalType('int', $recurringCost->interval);
    }

    /**
     * @test
     */
    public function get_recurring_costs()
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode([
                'data' => [
                    [
                        'id' => 123,
                        'reference_id' => 782,
                        'reference_name' => 'Example recurring cost',
                        'product' => [
                            "id" => 1,
                            'name' => ""
                        ],
                        'total' => 12.50,
                        'period' => 'month',
                        'interval' => 1,
                        'payment_method' => 'On Account',
                        'next_payment_at' => '2019-12-01',
                        'created_at' => '2016-06-07T16:29:06+0000'
                    ],
                    [
                        'id' => 1234,
                        'reference_id' => 782,
                        'reference_name' => 'Example recurring cost 1',
                        'product' => [
                            "id" => 1,
                            'name' => ""
                        ],
                        'total' => 12.50,
                        'period' => 'month',
                        'interval' => 1,
                        'payment_method' => 'On Account',
                        'next_payment_at' => '2019-12-01',
                        'created_at' => '2016-06-07T16:29:06+0000'
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
        $recurringCosts = $client->recurringCosts()->getPage();
        $items = $recurringCosts->getItems();

        $this->assertEquals(2, count($items));
        $this->assertTrue($items[0] instanceof RecurringCost);
        $this->assertTrue($items[1] instanceof RecurringCost);
    }

    /**
     * @test
     */
    public function get_recurring_cost_with_related_product()
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode([
                'data' => [
                    'id' => 123,
                    'name' => 'Example recurring cost',
                    'product' => [
                        'type' => 'server',
                        'id' => 12345,
                    ],
                    'total' => 12.50,
                    'period' => 'month',
                    'interval' => 1,
                    'payment_method' => 'On Account',
                    'next_payment_at' => '2019-12-01',
                    'created_at' => '2016-06-07T16:29:06+0000'
                ],
                'meta' => []
            ])),
        ]);

        $handler = HandlerStack::create($mock);
        $guzzle = new Guzzle(['handler' => $handler]);

        $client = new \UKFast\SDK\Billing\Client($guzzle);
        $recurringCost = $client->recurringCosts()->getById(123);

        $this->assertTrue($recurringCost->product instanceof Product);
        $this->assertEquals(12345, $recurringCost->product->id);
        $this->assertEquals('server', $recurringCost->product->type);
    }
}
