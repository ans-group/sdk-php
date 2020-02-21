<?php

namespace Tests\Billing;

use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use UKFast\SDK\Billing\Entities\CloudCost;

class CloudCostClientTest extends TestCase
{
    /**
     * @test
     */
    public function get_could_costs()
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode([
                'data' => [
                    [
                        'id' => 123,
                        'server_id' => 123456,
                        'resource' => [
                            'type' => 'CPU',
                            'quantity'=> 2,
                            'period' => 'Monthly',
                            'price' => 0.00694444,
                            'usage_since_last_invoice' => 136,
                            'cost_since_last_invoice' => 1.89,
                            'usage_for_period_estimate' => 136,
                            'cost_for_period_estimate' => 1.89,
                            'billing_start' => '2020-02-02T17:13:39+0000',
                            'billing_end' => '2020-03-02T17:13:39+0000',
                            'billing_due_date' => '2020-03-02',
                        ],
                    ],
                    [
                        'id' => 1234,
                        'server_id' => 123456,
                        'resource' => [
                            'type' => 'RAM',
                            'quantity'=> 2,
                            'period' => 'Monthly',
                            'price' => 0.00694444,
                            'usage_since_last_invoice' => 136,
                            'cost_since_last_invoice' => 1.89,
                            'usage_for_period_estimate' => 136,
                            'cost_for_period_estimate' => 1.89,
                            'billing_start' => '2020-02-02T17:13:39+0000',
                            'billing_end' => '0000-00-00 00:00:00',
                            'billing_due_date' => '2020-03-02',
                        ],
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

        $recurringCosts = $client->cloudCosts()->getPage();
        $items = $recurringCosts->getItems();

        $this->assertEquals(2, count($items));
        $this->assertTrue($items[0] instanceof CloudCost);
        $this->assertTrue($items[1] instanceof CloudCost);
    }

    /**
     * @test
     */
    public function get_could_billing_totals_since_last_invoice()
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode([
                'data' => [
                    [
                        'id' => 123,
                        'server_id' => 123456,
                        'resource' => [
                            'type' => 'CPU',
                            'quantity'=> 2,
                            'period' => 'Monthly',
                            'price' => 1,
                            'usage_since_last_invoice' => 100,
                            'cost_since_last_invoice' => 100,
                            'usage_for_period_estimate' => 136,
                            'cost_for_period_estimate' => 189,
                            'billing_start' => '2020-02-02T17:13:39+0000',
                            'billing_end' => '2020-03-02T17:13:39+0000',
                            'billing_due_date' => '2020-03-02',
                        ],
                    ],
                    [
                        'id' => 1234,
                        'server_id' => 123456,
                        'resource' => [
                            'type' => 'RAM',
                            'quantity'=> 2,
                            'period' => 'Monthly',
                            'price' => 2,
                            'usage_since_last_invoice' => 100,
                            'cost_since_last_invoice' => 200,
                            'usage_for_period_estimate' => 136,
                            'cost_for_period_estimate' => 189,
                            'billing_start' => '2020-02-02T17:13:39+0000',
                            'billing_end' => '0000-00-00 00:00:00',
                            'billing_due_date' => '2020-03-02',
                        ],
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

        $recurringCosts = $client->cloudCosts()->getTotalCostSinceLastInvoice(123456);
        $this->assertEquals(300, $recurringCosts[123456]['totalCostSinceLastInvoice']);
        $this->assertEquals(378, $recurringCosts[123456]['totalEstimatedCostForThePeriod']);
    }

    /**
     * @test
     */
    public function check_if_billion_period_is_completed_or_not()
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode([
                'data' => [
                    [
                        'id' => 123,
                        'server_id' => 123456,
                        'resource' => [
                            'type' => 'CPU',
                            'quantity'=> 2,
                            'period' => 'Monthly',
                            'price' => 1,
                            'usage_since_last_invoice' => 100,
                            'cost_since_last_invoice' => 100,
                            'usage_for_period_estimate' => 136,
                            'cost_for_period_estimate' => 189,
                            'billing_start' => '2020-02-02T17:13:39+0000',
                            'billing_end' => '2020-02-24T17:13:39+0000',
                            'billing_due_date' => '2020-03-02',
                        ],
                    ],
                    [
                        'id' => 123,
                        'server_id' => 123456,
                        'resource' => [
                            'type' => 'CPU',
                            'quantity'=> 2,
                            'period' => 'Monthly',
                            'price' => 1,
                            'usage_since_last_invoice' => 100,
                            'cost_since_last_invoice' => 100,
                            'usage_for_period_estimate' => 136,
                            'cost_for_period_estimate' => 189,
                            'billing_start' => '2020-02-02T17:13:39+0000',
                            'billing_end' => '0000-00-00 00:00:00',
                            'billing_due_date' => '2020-03-02',
                        ],
                    ]
                ],
                'meta' => [
                    'pagination' => [
                        'total' => 1,
                        'per_page' => 1,
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

        $page = $client->cloudCosts()->getPage();
        $recurringCloudCosts = $page->getItems();

        foreach ($recurringCloudCosts as $key => $recurringCloudCost) {
            if ($key == 0) {
                $this->assertEquals(true, $recurringCloudCost->isBillingCompleted());
            } elseif ($key == 1) {
                $this->assertEquals(false, $recurringCloudCost->isBillingCompleted());
            }
        }
    }
}
