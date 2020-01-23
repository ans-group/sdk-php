<?php

namespace UKFast\SDK\Billing;

use UKFast\SDK\Account\Entities\Invoice;
use UKFast\SDK\Client as BaseClient;

class InvoiceClient extends BaseClient
{
    protected $basePath = 'billing/';

    /**
     * Gets a paginated response of all invoices
     *
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return int|\UKFast\SDK\Page
     */
    public function getPage($page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest('v1/invoices', $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return $this->serializeInvoice($item);
        });

        return $page;
    }

    /**
     * Gets an individual invoice
     *
     * @param $id
     * @return mixed
     */
    public function getById($id)
    {
        $response = $this->request("GET", "v1/invoices/$id");
        $body = $this->decodeJson($response->getBody()->getContents());
        $item = $body->data;

        return $this->serializeInvoice($item);
    }

    /**
     * @param $item
     * @return Invoice
     */
    protected function serializeInvoice($item)
    {
        $invoice = new Invoice($item);

        return $invoice;
    }
}