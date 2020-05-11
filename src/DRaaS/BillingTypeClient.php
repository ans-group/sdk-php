<?php

namespace UKFast\SDK\DRaaS;

use UKFast\SDK\DRaaS\Entities\BillingType;
use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\Page;

class BillingTypeClient extends Client implements ClientEntityInterface
{
    const MAP = [
        'id' => 'id',
        'type' => 'type',
    ];

    /**
     * Gets a paginated response of billing types
     *
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return Page
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getPage($page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest("v1/billing-types", $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return $this->loadEntity($item);
        });

        return $page;
    }

    /**
     * Gets an individual billing-type resource
     *
     * @param int $id
     * @return BillingType
     */
    public function getById($id)
    {
        $response = $this->get("v1/billing-types/$id");
        $body = $this->decodeJson($response->getBody()->getContents());
        return $this->loadEntity($body->data);
    }

    /**
     * Load an instance of BillingType from API data
     * @param $data
     * @return BillingType
     */
    public function loadEntity($data)
    {
        return new BillingType($this->apiToFriendly($data, static::MAP));
    }
}
