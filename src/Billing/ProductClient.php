<?php

namespace UKFast\SDK\Billing;

use UKFast\SDK\Billing\Entities\Product;
use UKFast\SDK\Traits\PageItems;

class ProductClient extends Client
{
    use PageItems;

    protected $collectionPath = 'v2/products';

    public function loadEntity($data)
    {
        return new Product(
            $this->apiToFriendly($data, $this->getEntityMap())
        );
    }

    /**
     * @return array<string, string>
     */
    public function getEntityMap()
    {
        return Product::$entityMap;
    }
}
