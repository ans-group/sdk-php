<?php

namespace UKFast\SDK\eCloud;

use UKFast\SDK\eCloud\Entities\VpnGateway;
use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\Traits\PageItems;

class VpnGatewayClient extends Client implements ClientEntityInterface
{
    /** @use PageItems<VpnGateway> */
    use PageItems;

    protected $collectionPath = 'v2/vpn-gateways';

    public function getEntityMap()
    {
        return VpnGateway::$entityMap;
    }

    public function loadEntity($data)
    {
        return new VpnGateway(
            $this->apiToFriendly($data, VpnGateway::$entityMap)
        );
    }
}
