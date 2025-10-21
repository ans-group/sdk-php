<?php

namespace UKFast\SDK\eCloud;

use UKFast\SDK\eCloud\Entities\Product;
use UKFast\SDK\eCloud\Entities\ResourceTier;
use UKFast\SDK\eCloud\Entities\VPC\Iops;
use UKFast\SDK\eCloud\Entities\VpnGatewaySpecification;
use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\Traits\PageItems;
use UKFast\SDK\eCloud\Entities\AvailabilityZone;

class AvailabilityZoneClient extends Client implements ClientEntityInterface
{
    /** @use PageItems<AvailabilityZone> */
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
        return AvailabilityZone::$entityMap;
    }

    public function getProducts($id, $filters = [])
    {
        return $this->getChildResources($id, 'prices', function ($data) {
            return new Product($this->apiToFriendly($data, Product::$entityMap));
        }, $filters);
    }

    public function getResourceTiers($id, $filters = [])
    {
        return $this->getChildResources($id, 'resource-tiers', function ($data) {
            return new ResourceTier($this->apiToFriendly($data, ResourceTier::$entityMap));
        }, $filters);
    }

    public function getIops($id, $filters = [])
    {
        return $this->getChildResources($id, 'iops', function ($data) {
            return new Iops($this->apiToFriendly($data, Iops::$entityMap));
        }, $filters);
    }

    public function getVpnGatewaySpecifications($id, $filters = [])
    {
        return $this->getChildResources($id, 'vpn-gateway-specifications', function ($data) {
            return new VpnGatewaySpecification($this->apiToFriendly($data, VpnGatewaySpecification::$entityMap));
        }, $filters);
    }
}
