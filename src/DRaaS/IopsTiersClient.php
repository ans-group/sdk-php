<?php

namespace UKFast\SDK\DRaaS;

use UKFast\SDK\DRaaS\Entities\IopsTier;
use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\Page;

class IopsTiersClient extends Client implements ClientEntityInterface
{
    const MAP = [
        'id' => 'id',
        'iops_limit' => 'iopsLimit',
    ];

    /**
     * Gets a paginated response of IOPS tiers
     *
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return Page
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getPage($page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest("v1/iops-tiers", $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return $this->loadEntity($item);
        });

        return $page;
    }

    /**
     * Gets an individual IOPS tiers resource
     *
     * @param int $id
     * @return IopsTier
     */
    public function getById($id)
    {
        $response = $this->get("v1/iops-tiers/$id");
        $body = $this->decodeJson($response->getBody()->getContents());
        return $this->loadEntity($body->data);
    }

    /**
     * Load an instance of Datastore from API data
     * @param $data
     * @return IopsTier
     */
    public function loadEntity($data)
    {
        return new IopsTier($this->apiToFriendly($data, static::MAP));
    }
}
