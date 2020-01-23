<?php

namespace UKFast\SDK\Billing;

use UKFast\SDK\Billing\Entities\InvoiceQuery;
use UKFast\SDK\Client;
use UKFast\SDK\SelfResponse;

class InvoiceQueryClient extends Client
{
    protected $basePath = 'billing/';

    const MAP = [
        'contact_id' => 'contactId',
        'what_was_expected' => 'whatWasExpected',
        'what_was_received' => 'whatWasReceived',
        'proposed_solution' => 'proposedSolution',
        'invoice_ids' => 'invoiceIds',
        'contact_method' => 'contactMethod',
        'resolution_date' => 'resolutionDate'
    ];

    /**
     * Gets a paginated response of all invoice queries
     *
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @throws \UKFast\SDK\Exception\UKFastException
     * @return \UKFast\SDK\Page
     */
    public function getPage($page = 1, $perPage = 15, $filters = [])
    {
        $filters = $this->friendlyToApi($filters, self::MAP);
        $page = $this->paginatedRequest('v1/invoice-queries', $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return $this->serializeInvoiceQuery($item);
        });

        return $page;
    }

    /**
     * Gets an individual invoice query
     *
     * @param $id
     * @return InvoiceQuery
     */
    public function getById($id)
    {
        $response = $this->request("GET", "v1/invoice-queries/$id");
        $body = $this->decodeJson($response->getBody()->getContents());
        $item = $body->data;

        return $this->serializeInvoiceQuery($item);
    }

    /**
     * Creates a new Invoice Query
     *
     * @param $invoiceQuery
     * @return SelfResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function create($invoiceQuery)
    {
        $response = $this->post("v1/invoice-queries", json_encode($this->friendlyToApi($invoiceQuery, self::MAP)));
        $response = $this->decodeJson($response->getBody()->getContents());

        return (new SelfResponse($response))
            ->setClient($this)
            ->serializeWith(function ($response) {
                return $this->serializeInvoiceQuery($response->data);
            });
    }

    protected function serializeInvoiceQuery($raw)
    {
        return new InvoiceQuery($this->apiToFriendly($raw, self::MAP));
    }
}
