<?php

namespace Tests\Billing;

use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use UKFast\SDK\Billing\Entities\RecurringCost;

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
                    "id" => 1,
                    "type" => [
                        "id" => 1,
                        "name" => "name"
                    ],
                    "description" => "description",
                    "status" => "Active",
                    "order_id" => "PG1234",
                    "purchase_order_id" => "TEST",
                    "cost_centre_id" => 12,
                    "product" => [
                        "id" => 1,
                        "name" => "SOLO"
                    ],
                    "cost" => 45.99,
                    "period" => "monthly",
                    "interval" => 2,
                    "by_card" => true,
                    "next_payment_at" => "2020-06-21",
                    "end_date" => "2020-10-21",
                    "contract_end_date" => "2020-10-21",
                    "frozen_end_date" => "2020-10-21",
                    "migration_end_date" => "2020-10-21",
                    "created_at" => "2020-04-21T09:49:03+00:00",
                    "partner" => [
                        "id" => 1,
                        "cost" => "0.00"
                    ],
                    "project_id" => 1
                ],
                'meta' => []
            ])),
        ]);

        $handler = HandlerStack::create($mock);
        $guzzle = new Guzzle(['handler' => $handler]);

        $client = new \UKFast\SDK\Billing\Client($guzzle);
        $recurringCost = $client->recurringCosts()->getById(123);

        $this->assertTrue($recurringCost instanceof RecurringCost);
        $this->assertEquals(1, $recurringCost->id);
        $this->assertEquals(1, $recurringCost->type->id);
        $this->assertEquals('name', $recurringCost->type->name);
        $this->assertEquals('description', $recurringCost->description);
        $this->assertEquals('Active', $recurringCost->status);
        $this->assertEquals('PG1234', $recurringCost->orderId);
        $this->assertEquals('TEST', $recurringCost->purchaseOrderId);
        $this->assertEquals(12, $recurringCost->costCentreId);
        $this->assertEquals(1, $recurringCost->product->id);
        $this->assertEquals('SOLO', $recurringCost->product->name);
        $this->assertEquals(45.99, $recurringCost->cost);
        $this->assertEquals('monthly', $recurringCost->period);
        $this->assertEquals(2, $recurringCost->interval);
        $this->assertTrue($recurringCost->byCard);
        $this->assertTrue($recurringCost->nextPaymentAt instanceof \DateTime);
        $this->assertTrue($recurringCost->endDate instanceof \DateTime);
        $this->assertTrue($recurringCost->contractEndDate instanceof \DateTime);
        $this->assertTrue($recurringCost->frozenEndDate instanceof \DateTime);
        $this->assertTrue($recurringCost->migrationEndDate instanceof \DateTime);
        $this->assertTrue($recurringCost->createdAt instanceof \DateTime);
        $this->assertEquals(1, $recurringCost->partner->id);
        $this->assertEquals("0.00", $recurringCost->partner->cost);
        $this->assertEquals(1, $recurringCost->projectId);
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
                        "id" => 1,
                        "type" => [
                            "id" => 1,
                            "name" => "name"
                        ],
                        "description" => "description",
                        "status" => "Active",
                        "order_id" => "PG1234",
                        "purchase_order_id" => "TEST",
                        "cost_centre_id" => 12,
                        "product" => [
                            "id" => 1,
                            "name" => "SOLO"
                        ],
                        "cost" => 45.99,
                        "period" => "monthly",
                        "interval" => 2,
                        "by_card" => true,
                        "next_payment_at" => "2020-06-21",
                        "end_date" => "2020-10-21",
                        "contract_end_date" => "2020-10-21",
                        "frozen_end_date" => "2020-10-21",
                        "migration_end_date" => "2020-10-21",
                        "created_at" => "2020-04-21T09:49:03+00:00",
                        "partner" => [
                            "id" => 1,
                            "cost" => "0.00"
                        ],
                        "project_id" => 1
                    ],
                    [
                        "id" => 2,
                        "type" => [
                            "id" => 2,
                            "name" => "name"
                        ],
                        "description" => "description",
                        "status" => "Active",
                        "order_id" => "PG1234",
                        "purchase_order_id" => "TEST",
                        "cost_centre_id" => 12,
                        "product" => [
                            "id" => 1,
                            "name" => "SOLO"
                        ],
                        "cost" => 45.99,
                        "period" => "monthly",
                        "interval" => 2,
                        "by_card" => true,
                        "next_payment_at" => "2020-06-21",
                        "end_date" => "2020-10-21",
                        "contract_end_date" => "2020-10-21",
                        "frozen_end_date" => "2020-10-21",
                        "migration_end_date" => "2020-10-21",
                        "created_at" => "2020-04-21T09:49:03+00:00",
                        "partner" => [
                            "id" => 1,
                            "cost" => "0.00"
                        ],
                        "project_id" => 2
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
}
