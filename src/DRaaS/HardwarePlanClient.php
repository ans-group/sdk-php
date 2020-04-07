<?php

namespace UKFast\SDK\DRaaS;

use UKFast\SDK\DRaaS\Entities\HardwarePlan;
use UKFast\SDK\Entities\ClientEntityInterface;

class HardwarePlanClient extends Client implements ClientEntityInterface
{
    const MAP = [];

    /**
     * Gets a paginated response of hardware Plans
     *
     * @param $solutionId
     * @param int $page
     * @param int $perPage
     * @return int|\UKFast\SDK\Page
     */
    public function getPage($solutionId, $page = 1, $perPage = 15)
    {
        $page = $this->paginatedRequest("v1/solutions/$solutionId/hardware-plans", $page, $perPage);
        $page->serializeWith(function ($item) {
            return $this->loadEntity($item);
        });

        return $page;
    }

    /**
     * Gets an individual failover plan
     *
     * @param $solutionId
     * @param int $id
     * @return HardwarePlan
     */
    public function getById($solutionId, $id)
    {
        $response = $this->get("v1/solutions/$solutionId/hardware-plans/$id");
        $body = $this->decodeJson($response->getBody()->getContents());
        return $this->loadEntity($body->data);
    }

    /**
     * @param $data
     * @return mixed|HardwarePlan
     */
    public function loadEntity($data)
    {
        return new HardwarePlan($this->apiToFriendly($data, static::MAP));
    }
}
