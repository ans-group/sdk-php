<?php

namespace UKFast\SDK\eCloud;

use UKFast\SDK\eCloud\Entities\VpnGatewaySpecification;
use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\Traits\PageItems;

class VpnGatewaySpecificationClient extends Client implements ClientEntityInterface
{
    use PageItems;

    protected $collectionPath = 'v2/vpn-gateway-specifications';

    public function getEntityMap()
    {
        return VpnGatewaySpecification::$entityMap;
    }

    public function loadEntity($data)
    {
        return new VpnGatewaySpecification(
            $this->apiToFriendly($data, VpnGatewaySpecification::$entityMap)
        );
    }
}
