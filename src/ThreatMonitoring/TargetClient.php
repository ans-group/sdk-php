<?php

namespace UKFast\SDK\ThreatMonitoring;

use UKFast\SDK\ThreatMonitoring\Entities\Target;

class TargetClient extends Client
{
    const MAP = [
        'created_at' => 'createdAt',
        'updated_at' => 'updatedAt'
    ];

    /**
     * Get the paginated response of targets
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return int|\UKFast\SDK\Page
     */
    public function getPage($page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest('v1/targets', $page, $perPage, $filters);

        $page->serializeWith(function ($item) {
            return $this->serializeResponse($item);
        });

        return $page;
    }

    /**
     * Get a target by its ID
     * @param $id
     * @return Target
     */
    public function getById($id)
    {
        $response = $this->get('v1/targets/' . $id);
        $body = $this->decodeJson($response->getBody()->getContents());
        return $this->serializeResponse($body->data);
    }

    /**
     * Serialize the response to use friendly names
     * @param $data
     * @return Target
     */
    public function serializeResponse($data)
    {
        return new Target($this->apiToFriendly($data, static::MAP));
    }
}
