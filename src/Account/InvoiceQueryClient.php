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
     * Gets a paginated response of all invoice queries
     *
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return Page
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getPage($page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest('v1/invoice-queries', $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return new InvoiceQuery($item);
        });

        return $page;
    }

    /**
     * Gets an individual invoice query
     *
     * @param string $id
     * @return InvoiceQuery
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getById($id)
    {
        $response = $this->request("GET", "v1/invoice-queries/$id");
        $body = $this->decodeJson($response->getBody()->getContents());
        return new InvoiceQuery($body->data);
    }

    /**
     * @param $invoiceQuery
     * @return SelfResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function create($invoiceQuery)
    {
        $response = $this->post("v1/invoice-queries", $this->invoiceQueryToJson($invoiceQuery));
        $response = $this->decodeJson($response->getBody()->getContents());

        return (new SelfResponse($response))
            ->setClient($this)
            ->serializeWith(function ($response) {
                return $this->serializeInvoiceQuery($response->data);
            });
    }

    /**
     * Converts a response stdClass into an InvoiceQuery object
     *
     * @param \stdClass
     * @return \UKFast\SDK\Account\Entities\InvoiceQuery
     */
    protected function serializeInvoiceQuery($item)
    {
        $invoiceQuery = new Entities\InvoiceQuery($item);

        return $invoiceQuery;
    }

    protected function invoiceQueryToJson($invoiceQuery)
    {
        $payload = [
            'contact_id' => $invoiceQuery->contactId,
            'amount' => $invoiceQuery->amount,
            'what_was_expected' => $invoiceQuery->whatWasExpected,
            'what_was_received' => $invoiceQuery->whatWasReceived,
            'proposed_solution' => $invoiceQuery->proposedSolution,
            'invoice_ids' => $invoiceQuery->invoiceIds,
            'contact_method' => $invoiceQuery->contactMethod,
            'resolution' => $invoiceQuery->resolution,
            'resolution_date' => $invoiceQuery->resolutionDate,
            'status' => $invoiceQuery->status
        ];

        return json_encode($payload);
    }
}
