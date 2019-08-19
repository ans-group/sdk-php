<?php

namespace UKFast\SDK\Account;

use UKFast\SDK\Account\Entities\Invoice;
use UKFast\SDK\Client as BaseClient;
use UKFast\SDK\Page;
use UKFast\SDK\SelfResponse;

class InvoiceClient extends BaseClient
{
    protected $basePath = 'account/';
    
    /**
     * Gets a paginated response of all Invoices
     *
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return Page
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getPage($page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest('v1/invoices', $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return new Invoice($item);
        });

        return $page;
    }

    /**
     * Gets an individual invoice
     *
     * @param string $id
     * @return Invoice
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getById($id)
    {
        $response = $this->request("GET", "v1/invoices/$id");
        $body = $this->decodeJson($response->getBody()->getContents());
        return new Invoice($body->data);
    }
}
