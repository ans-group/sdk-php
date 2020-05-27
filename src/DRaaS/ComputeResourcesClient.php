<?php

namespace UKFast\SDK\DRaaS;

use UKFast\SDK\DRaaS\Entities\ComputeResources;
use UKFast\SDK\Entities\ClientEntityInterface;

class ComputeResourcesClient extends Client implements ClientEntityInterface
{
    const MAP = [
        'hardware_plan_id' => 'hardwarePlanId'
    ];

    /**
     * Gets an individual set of compute resources by id
     *
     * @param $solutionId
     * @param int $id
     * @return ComputeResources
     */
    public function getById($solutionId, $id)
    {
        $response = $this->get("v1/solutions/$solutionId/compute-resources/$id");
        $body = $this->decodeJson($response->getBody()->getContents());
        return $this->loadEntity($body->data);
    }


    /**
     * Gets a paginated response of compute resources
     *
     * @param $solutionId
     * @param int $page
     * @param int $perPage
     * @return int|\UKFast\SDK\Page
     */
    public function getPage($solutionId, $page = 1, $perPage = 15)
    {
        $page = $this->paginatedRequest("v1/solutions/$solutionId/compute-resources", $page, $perPage);
        $page->serializeWith(function ($item) {
            return $this->loadEntity($item);
        });

        return $page;
    }

    public function loadEntity($data)
    {
        return new ComputeResources($this->apiToFriendly($data, static::MAP));
    }
}
