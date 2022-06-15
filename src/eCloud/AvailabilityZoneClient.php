<?php

namespace UKFast\SDK\eCloud;

use UKFast\SDK\eCloud\Entities\Product;
use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\Traits\PageItems;
use UKFast\SDK\eCloud\Entities\AvailabilityZone;

class AvailabilityZoneClient extends Client implements ClientEntityInterface
{
    use PageItems;

    protected $collectionPath = 'v2/availability-zones';

    public function loadEntity($data)
    {
        return new AvailabilityZone(
            $this->apiToFriendly($data, $this->getEntityMap())
        );
    }

    public function getEntityMap()
    {
        return [
            'id' => 'id',
            'name' => 'name',
            'code' => 'code',
            'datacentre_site_id' => 'datacentreSiteId'
        ];
    }

    public function getProducts($id, $filters = [])
    {
        return $this->getChildResources($id, 'prices', function ($data) {
            return new Product($this->apiToFriendly($data, Product::$entityMap));
        }, $filters);
    }
}
