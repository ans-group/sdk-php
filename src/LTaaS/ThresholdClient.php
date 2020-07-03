<?php

namespace UKFast\SDK\LTaaS;

use GuzzleHttp\Exception\GuzzleException;
use UKFast\SDK\Page;
use UKFast\SDK\LTaaS\Entities\Threshold;

class ThresholdClient extends Client
{
    protected $basePath = 'ltaas/';

    /**
     * Gets paginated response for all of the thresholds
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return int|Page
     * @throws GuzzleException
     */
    public function getPage($page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest('v1/thresholds', $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return new Threshold($item);
        });

        return $page;
    }

    /**
     * Get all the thresholds
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

        $thresholds = $page->getItems();
        if ($page->totalPages() == 1) {
            return $thresholds;
        }

        // get any remaining pages
        while ($page->pageNumber() < $page->totalPages()) {
            $page = $this->getPage($currentPage++, $perPage, $filters);

            $thresholds = array_merge(
                $thresholds,
                $page->getItems()
            );
        }

        return $thresholds;
    }

    public function getById($id)
    {
        $response = $this->get('v1/thresholds/' . $id);
        $body = $this->decodeJson($response->getBody()->getContents());

        return new Threshold($body->data);
    }
}
