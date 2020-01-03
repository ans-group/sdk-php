<?php

namespace UKFast\SDK\Account;

use UKFast\SDK\Client as BaseClient;
use UKFast\SDK\Account\Entities\Credit;

class CreditClient extends BaseClient
{
    protected $basePath = 'account/';

    /**
     * Maps entity property names to API names
     *
     * @var array
     */
    protected $requestMap = [
        'type'      => 'type',
        'total'     => 'total',
        'remaining' => 'remaining',
    ];

    /**
     * Gets account credits
     *
     * @return Credit Array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getAll()
    {
        $response = $this->request("GET", "v1/credits");
        $body = $this->decodeJson($response->getBody()->getContents());

        return array_map(function ($item) {
            return new Credit($item);
        }, $body->data);
    }

    /**
     * Gets a paginated response of credits
     *
     * @param int   $page
     * @param int   $perPage
     * @param array $filters
     * @return \UKFast\SDK\Page
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getPage($page = 1, $perPage = 20, $filters = [])
    {
        $filters = $this->friendlyToApi($filters, $this->requestMap);

        $page = $this->paginatedRequest('v1/credits', $page, $perPage, $filters);

        $page->serializeWith(function ($item) {
            return $this->serializeCredit($item);
        });

        return $page;
    }

    /**
     * Maps an API credit to a credit entity
     *
     * @param $item
     * @return Credit
     */
    public function serializeCredit($item)
    {
        return new Credit([
            'type'      => $item->type,
            'total'     => $item->total,
            'remaining' => $item->remaining,
        ]);
    }
}
