<?php

namespace UKFast\SDK\Traits;

use UKFast\SDK\Page;

trait PageItems
{
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
        $page = $this->paginatedRequest($this->collectionPath, $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return $this->loadEntity($item);
        });

        return $page;
    }

    /**
     * Get a single item from the collection
     * @param $id
     * @return mixed
     */
    public function getById($id)
    {
        $response = $this->get($this->collectionPath . '/' . $id);
        $body = $this->decodeJson($response->getBody()->getContents());
        return $this->loadEntity($body->data);
    }

    /**
     * Gets array of all Page Items
     *
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
}
