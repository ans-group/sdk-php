<?php

namespace UKFast\SDK\eCloud;

use UKFast\SDK\eCloud\Entities\Product;
use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\Traits\PageItems;
use UKFast\SDK\eCloud\Entities\Region;

class RegionClient extends Client implements ClientEntityInterface
{
    use PageItems;

    protected $collectionPath = 'v2/regions';

    public function loadEntity($data)
    {
        return new Region(
            $this->apiToFriendly($data, $this->getEntityMap())
        );
    }

    public function getEntityMap()
    {
        return [
            'id' => 'id',
            'name' => 'name',
        ];
    }

    /**
     * Get an array of all products and prices for the region
     *
     * @param int $id Region ID
     * @param array $filters
     * @return array
     */
    public function getProducts($id, $filters = [])
    {
        $page = $this->paginatedRequest($this->collectionPath . '/' . $id . '/prices', 1, 15, $filters);

        if ($page->totalItems() == 0) {
            return [];
        }

        $loadEntity = function ($data) {
            return new Product($this->apiToFriendly($data, Product::$entityMap));
        };

        $page->serializeWith($loadEntity);

        $items = $page->getItems();
        if ($page->totalPages() == 1) {
            return $items;
        }

        while ($page->pageNumber() < $page->totalPages()) {
            $page = $this->getPage($page->pageNumber() + 1, 15, $filters);

            $page->serializeWith($loadEntity);
            $items = array_merge(
                $items,
                $page->getItems()
            );
        }
        return $items;
    }
}
