<?php
/**
 * @author: John Birch-Evans <john.birch-evans@ukfast.co.uk>
 * @copyright: 2020 UKFast.net Ltd
 */
namespace UKFast\SDK\ThreatMonitoring;

use UKFast\SDK\Page;
use UKFast\SDK\ThreatMonitoring\Entities\Alert;

class AlertClient extends Client
{
    protected $basePath = 'threat-monitoring/';

    const MAP = [
        'agent_id' => 'agentId',
        'agent_friendly_name' => 'agentFriendlyName',
        'pci_dss' => 'pciDss',
        'full_log' => 'fullLog'
    ];

    /**
     * Gets paginated response for all the alerts
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return int|Page
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getPage($page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest('v1/alerts', $page, $perPage, $filters);

        $page->serializeWith(function ($item) {
            return $this->serializeResponse($item);
        });

        return $page;
    }

    /**
     * Get all the alerts by looping the paginated results
     */
    public function getAll($filters = [])
    {
        // get first page
        $page = $this->getPage($currentPage = 1, $perPage = 100, $filters);
        if ($page->totalItems() == 0) {
            return [];
        }

        $jobs = $page->getItems();
        if ($page->totalPages() == 1) {
            return $jobs;
        }

        // get any remaining pages
        while ($page->pageNumber() < $page->totalPages()) {
            $page = $this->getPage($currentPage++, $perPage, $filters);

            $jobs = array_merge(
                $jobs,
                $page->getItems()
            );
        }

        return $jobs;
    }

    public function getById($id)
    {
        $response = $this->request("GET", "v1/alerts/$id");
        $body = $this->decodeJson($response->getBody()->getContents());
        return $this->serializeResponse($body->data);
    }

    /**
     * Serialize the response to use friendly names
     * @param $data
     * @return Alert
     */
    public function serializeResponse($data)
    {
        return new Alert($this->apiToFriendly($data, static::MAP));
    }
}
