<?php

namespace UKFast\SDK\Loadbalancers;

use UKFast\SDK\Client as BaseClient;
use UKFast\SDK\Loadbalancers\Entities\Bind;
use UKFast\SDK\Page;

class BindsClient extends BaseClient
{
    protected $collectionPath = 'v2/binds';

    public function getEntityMap()
    {
        return Bind::$entityMap;
    }

    public function loadEntity($data)
    {
        return new Bind($this->apiToFriendly($data, $this->getEntityMap()));
    }

    /**
     * Get a paginated response from a collection
     *
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return Page
     */
    public function getPage($page = 1, $perPage = 15, $filters = [])
    {
        $entityMap = $this->getEntityMap();
        if (!empty($entityMap)) {
            $filters = $this->friendlyToApi($filters, $entityMap);
        }

        $page = $this->paginatedRequest($this->collectionPath, $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return $this->loadEntity($item);
        });

        return $page;
    }

    /**
     * Get an array of all items from all pages
     *
     * @param array $filters
     * @return array
     */
    public function getAll($filters = [])
    {
        // get first page
        $page = $this->getPage(1, $perPage = 100, $filters);
        if ($page->totalItems() == 0) {
            return [];
        }

        $items = $page->getItems();
        if ($page->totalPages() == 1) {
            return $items;
        }

        // get any remaining pages
        while ($page->pageNumber() < $page->totalPages()) {
            $page = $this->getPage($page->pageNumber() + 1, $perPage, $filters);
            $items = array_merge(
                $items,
                $page->getItems()
            );
        }

        return $items;
    }
}
