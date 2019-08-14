<?php

namespace UKFast\SDK\Account;

use UKFast\SDK\Account\Entities\InvoiceQuery;
use UKFast\SDK\Client as BaseClient;
use UKFast\SDK\Page;
use UKFast\SDK\SelfResponse;

class InvoiceQueryClient extends BaseClient
{
    protected $basePath = 'account/';

    /**
     * Gets an individual invoice query
     *
     * @param string $id
     * @return InvoiceQuery
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getById($id)
    {
        $response = $this->request("GET", "v1/invoices/query/$id");
        $body = $this->decodeJson($response->getBody()->getContents());
        return new InvoiceQuery($body->data);
    }
}
