<?php

namespace UKFast\SDK\DRaaS;

use UKFast\SDK\DRaaS\Entities\NetworkAppliance;
use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\Page;

class NetworkApplianceClient extends Client implements ClientEntityInterface
{
    const MAP = [
        'id' => 'id',
        'hardware_plan_id' => 'hardwarePlanId',
        'solution_id' => 'solutionId',
    ];

    /**
     * Get a paginated response from a collection
     *
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return Page
     */
    public function getPage($page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest('v1/network-appliances', $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return $this->loadEntity($item);
        });

        return $page;
    }

    /**
     * Get a single item from the collection
     * @param $id
     * @return mixed
     */
    public function getById($id)
    {
        $response = $this->get('v1/network-appliances/' . $id);
        $body = $this->decodeJson($response->getBody()->getContents());
        return $this->loadEntity($body->data);
    }

    /**
     * @param $data
     * @return NetworkAppliance
     */
    public function loadEntity($data)
    {
        return new NetworkAppliance($this->apiToFriendly($data, static::MAP));
    }
}
