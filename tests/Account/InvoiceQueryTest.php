<?php

namespace Tests\Account;

use DateTime;
use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use UKFast\SDK\SelfResponse;
use UKFast\SDK\Account\Entities\InvoiceQuery;

class InvoiceQueryTest extends TestCase
{
    /**
     * @test
     */
    public function get_invoice_query_by_id()
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode([
                "data" => [
                    "id" => 1,
                    "contact_id" => 1,
                    "amount" => 5000,
                    "what_was_expected" => "I didn't get the full amount",
                    "what_was_received" => "4500",
                    "proposed_solution" => "Resolve the difference",
                    "invoice_ids" => [
                            2514571,
                            2456789,
                            1245678
                    ],
                    "contact_method" => "email"
                ],
                "meta" => []
            ])),
        ]);

        $handler = HandlerStack::create($mock);
        $guzzle = new Guzzle(['handler' => $handler]);

        $id = 1;

        $client = new \UKFast\SDK\Account\Client($guzzle);
        $invoiceQuery = $client->invoiceQueries()->getById($id);

        $this->assertTrue($invoiceQuery instanceof \UKFast\SDK\Account\Entities\InvoiceQuery);
        $this->assertEquals($id, $invoiceQuery->id);
        $this->assertEquals(1, $invoiceQuery->contactId);
        $this->assertEquals(5000, $invoiceQuery->amount);
        $this->assertEquals("I didn't get the full amount", $invoiceQuery->whatWasExpected);
        $this->assertEquals("4500", $invoiceQuery->whatWasReceived);
        $this->assertEquals("Resolve the difference", $invoiceQuery->proposedSolution);
        $this->assertEquals([2514571, 2456789, 1245678], $invoiceQuery->invoiceIds);
        $this->assertEquals("email", $invoiceQuery->contact_method);
    }

    /**
     * @test
     */
    public function check_self_response_parses_query_response()
    {
        $response = (object) [
            'data' => (object) [
                'id' => 123
            ],
            'meta' => (object) [
                'location' => 'https://api.ukfast.io/account/v1/invoices/query/123'
            ],
        ];

        $selfResponse = new SelfResponse($response);

        $this->assertEquals(123, $selfResponse->getId());
        $this->assertEquals('https://api.ukfast.io/account/v1/invoices/query/123', $selfResponse->getLocation());
    }
}
