<?php

namespace UKFast\SDK\SafeDNS;

use UKFast\SDK\Client;
use UKFast\SDK\Page;
use UKFast\SDK\SafeDNS\Entities\Record;

class RecordClient extends Client
{
    protected $basePath = 'safedns/';


    /**
     * Gets an individual Record
     *
     * @param string $id
     * @return Record
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getById($id)
    {
        $response = $this->request("GET", "v1/records/$id");
        $body = $this->decodeJson($response->getBody()->getContents());
        return new Record($body->data);
    }


    /**
     * Get records by zone name
     * @param $zoneName
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return int|Page
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getByZoneName($zoneName, $page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest('v1/zones/'.$zoneName.'/records', $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return new Record($item);
        });

        return $page;
    }

    /**
     * Gets array containing all records for a zone
     *
     * @param $zoneName
     * @param array $filters
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getAllByZoneName($zoneName, $filters = [])
    {
        // get first page
        $page = $this->getByZoneName($zoneName, $currentPage = 1, $perPage = 50, $filters);
        if ($page->totalItems() == 0) {
            return [];
        }

        $items = $page->getItems();
        if ($page->totalPages() == 1) {
            return $items;
        }

        // get any remaining pages
        while ($page->pageNumber() < $page->totalPages()) {
            $page = $this->getRecordsByName($zoneName, $currentPage++, $perPage, $filters);

            $items = array_merge(
                $items,
                $page->getItems()
            );
        }

        return $items;
    }
}
