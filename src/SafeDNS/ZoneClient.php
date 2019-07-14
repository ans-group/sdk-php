<?php

namespace UKFast\SDK\SafeDNS;

use UKFast\SDK\Client;
use UKFast\SDK\Page;
use UKFast\SDK\SafeDNS\Entities\Zone;

class ZoneClient extends Client
{
    protected $basePath = 'safedns/';

    /**
     * Gets a paginated response of all Zones
     *
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return Page
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getPage($page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest('v1/zones', $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return new Zone($item);
        });

        return $page;
    }


    /**
     * Gets array containing all Zones
     *
     * @param array $filters
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getAll($filters = [])
    {
        // get first page
        $page = $this->getPage($currentPage = 1, $perPage = 50, $filters);
        if ($page->totalItems() == 0) {
            return [];
        }

        $items = $page->getItems();
        if ($page->totalPages() == 1) {
            return $items;
        }

        // get any remaining pages
        while ($page->pageNumber() < $page->totalPages()) {
            $page = $this->getPage($currentPage++, $perPage, $filters);

            $items = array_merge(
                $items,
                $page->getItems()
            );
        }

        return $items;
    }

    /**
     * Gets an individual Zone
     *
     * @param string $name
     * @return Zone
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getByName($name)
    {
        $response = $this->request("GET", "v1/zones/$name");
        $body = $this->decodeJson($response->getBody()->getContents());
        return new Zone($body->data);
    }
}
