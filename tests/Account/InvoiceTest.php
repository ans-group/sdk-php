<?php

namespace Tests\Account;

use DateTime;
use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use UKFast\SDK\Account\Entities\Invoice;

class InvoiceTest extends TestCase
{
    /**
     * @test
     */
    public function get_page_of_invoices()
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode([
                'data' => [
                    [
                        'id' => 1,
                        "date" => "2019-08-13",
                        "paid" => true,
                        "net" => 15.6,
                        "vat" => 3.12,
                        "gross" => 18.72
                    ],
                    [
                        "id" => 54110,
                        "date" => "2006-10-26",
                        "paid" => true,
                        "net" => 15.6,
                        "vat" => 3.12,
                        "gross" => 18.72
                    ]
                ],
                "meta" => [
                    "pagination" => [
                        "total" => 40,
                        "count" => 40,
                        "per_page" => 100,
                        "current_page" => 1,
                        "total_pages" => 1,
                        "links" => []
                    ]
                ]
            ])),
        ]);

        $handler = HandlerStack::create($mock);
        $guzzle = new Guzzle(['handler' => $handler]);

        $client = new \UKFast\SDK\Account\Client($guzzle);
        $page = $client->invoices()->getPage();

        $this->assertTrue($page instanceof \UKFast\SDK\Page);
        $request = $page->getItems()[0];

        $this->assertTrue($request instanceof \UKFast\SDK\Account\Entities\Invoice);
        $this->assertEquals(1, $request->id);
        $this->assertInstanceOf(DateTime::class, $request->date);
        $this->assertEquals(true, $request->paid);
        $this->assertEquals(15.6, $request->net);
        $this->assertEquals(3.12, $request->vat);
        $this->assertEquals(18.72, $request->gross);
    }

    /**
     * @test
     */
    public function get_invoice_by_id()
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode([
                'data' => [
                    'id' => 1,
                    "date" => "2019-08-14",
                    "paid" => true,
                    "net" => 15.6,
                    "vat" => 3.12,
                    "gross" => 18.72
                ],
                "meta" => []
            ])),
        ]);

        $handler = HandlerStack::create($mock);
        $guzzle = new Guzzle(['handler' => $handler]);

        $id = 1;

        $client = new \UKFast\SDK\Account\Client($guzzle);
        $invoice = $client->invoices()->getById($id);

        $this->assertTrue($invoice instanceof \UKFast\SDK\Account\Entities\Invoice);
        $this->assertEquals($id, $invoice->id);
        $this->assertInstanceOf(DateTime::class, $invoice->date);
        $this->assertEquals(true, $invoice->paid);
        $this->assertEquals(15.6, $invoice->net);
        $this->assertEquals(3.12, $invoice->vat);
        $this->assertEquals(18.72, $invoice->gross);
    }
}
