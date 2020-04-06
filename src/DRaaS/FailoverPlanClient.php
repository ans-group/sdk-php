<?php

namespace UKFast\SDK\DRaaS;

use UKFast\SDK\DRaaS\Entities\FailoverPlan;
use UKFast\SDK\Entities\ClientEntityInterface;

class FailoverPlanClient extends Client implements ClientEntityInterface
{
    const MAP = [];

    /**
     * Gets a paginated response of failover Plans
     *
     * @param $solutionId
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return int|\UKFast\SDK\Page
     */
    public function getPage($solutionId, $page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest("v1/solutions/$solutionId/failover-plans", $page, $perPage, $filters);
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
     * @return FailovePlan
     */
    public function getById($solutionId, $id)
    {
        $response = $this->get("v1/solutions/$solutionId/failover-plans/$id");
        $body = $this->decodeJson($response->getBody()->getContents());
        return $this->loadEntity($body->data);
    }

    /**
     * @param $data
     * @return mixed|FailoverPlan
     */
    public function loadEntity($data)
    {
        return new FailoverPlan($this->apiToFriendly($data, static::MAP));
    }

    /**
     * Start a failover plan
     * @param $solutionId
     * @param $failoverPlanId
     * @param $startNow
     * @param $startDate
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function start($solutionId, $failoverPlanId, $startNow, $startDate)
    {
        return $this->post(
                'v1/solutions/' . $solutionId . '/failover-plans/' . $failoverPlanId,
                json_encode([
                    'start_now' => $startNow,
                    'start_date' => $startDate,
                ]),
                ['Content-Type' => 'application/json']
            )->getStatusCode() == 200;
    }

    /**
     * Stop a failover plan
     * @param $solutionId
     * @param $failoverPlanId
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function stop($solutionId, $failoverPlanId)
    {
        return $this->post(
                'v1/solutions/' . $solutionId . '/failover-plans/' . $failoverPlanId,
                json_encode([]),
                ['Content-Type' => 'application/json']
            )->getStatusCode() == 200;
    }
}
