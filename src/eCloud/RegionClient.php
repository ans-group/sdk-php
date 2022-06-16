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

    public function getProducts($id, $filters = [])
    {
        return $this->getChildResources($id, 'prices', function ($data) {
            return new Product($this->apiToFriendly($data, Product::$entityMap));
        }, $filters);
    }
}
