<?php

namespace UKFast\SDK\LTaaS;

use GuzzleHttp\Exception\GuzzleException;
use UKFast\SDK\Page;
use UKFast\SDK\LTaaS\Entities\Scenario;

class ScenarioClient extends Client
{
    protected $basePath = 'ltaas/';

    /**
     * Gets paginated response for all of the scenarios
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return int|Page
     * @throws GuzzleException
     */
    public function getPage($page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest('v1/scenarios', $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return new Scenario($item);
        });

        return $page;
    }

    /**
     * Get all the scenarios
     * @param array $filters
     * @return array
     * @throws GuzzleException
     */
    public function getAll($filters = [])
    {
        // get first page
        $page = $this->getPage($currentPage = 1, $perPage = 100, $filters);
        if ($page->totalItems() == 0) {
            return [];
        }

        $scenarios = $page->getItems();
        if ($page->totalPages() == 1) {
            return $scenarios;
        }

        // get any remaining pages
        while ($page->pageNumber() < $page->totalPages()) {
            $page = $this->getPage($currentPage++, $perPage, $filters);

            $scenarios = array_merge(
                $scenarios,
                $page->getItems()
            );
        }

        return $scenarios;
    }
}
