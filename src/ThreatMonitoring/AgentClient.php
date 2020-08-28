<?php
/**
 * @author: John Birch-Evans <john.birch-evans@ukfast.co.uk>
 * @copyright: 2020 UKFast.net Ltd
 */

namespace UKFast\SDK\ThreatMonitoring;

use UKFast\SDK\Page;
use UKFast\SDK\ThreatMonitoring\Entities\Agent;

class AgentClient extends Client
{
    const MAP = [
        'threat_response_enabled' => 'threatResponseEnabled',
        'server_id' => 'serverId',
        'hosting_type' => 'hostingType',
        'os_version' => 'osVersion',
        'created_at' => 'createdAt',
        'updated_at' => 'updatedAt'
    ];

    /**
     * Gets paginated response for all the agents
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return int|Page
     */
    public function getPage($page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest('v1/agents', $page, $perPage, $filters);

        $page->serializeWith(function ($item) {
            return $this->serializeResponse($item);
        });

        return $page;
    }

    /**
     * Get all the agents
     * @param array $filters
     * @return array
     */
    public function getAll($filters = [])
    {
        // get first page
        $page = $this->getPage($currentPage = 1, $perPage = 100, $filters);
        if ($page->totalItems() == 0) {
            return [];
        }

        $agents = $page->getItems();
        if ($page->totalPages() == 1) {
            return $agents;
        }

        // get any remaining pages
        while ($page->pageNumber() < $page->totalPages()) {
            $page = $this->getPage($currentPage++, $perPage, $filters);

            $thresholds = array_merge(
                $agents,
                $page->getItems()
            );
        }

        return $agents;
    }

    /**
     * Get an agent by its ID
     * @param $id
     * @return Agent
     */
    public function getById($id)
    {
        $response = $this->get('v1/agents/' . $id);
        $body = $this->decodeJson($response->getBody()->getContents());
        return $this->serializeResponse($body->data);
    }

    /**
     * Serialize the response to use friendly names
     * @param $data
     * @return Agent
     */
    public function serializeResponse($data)
    {
        return new Agent($this->apiToFriendly($data, static::MAP));
    }
}
