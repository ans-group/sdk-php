<?php

namespace UKFast\SDK\eCloud;

use UKFast\SDK\eCloud\Entities\VpnGatewayUser;
use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\Traits\PageItems;

class VpnGatewayUserClient extends Client implements ClientEntityInterface
{
    use PageItems;

    protected $collectionPath = 'v2/vpn-gateway-users';

    public function getEntityMap()
    {
        return VpnGatewayUser::$entityMap;
    }

    public function loadEntity($data)
    {
        return new VpnGatewayUser(
            $this->apiToFriendly($data, VpnGatewayUser::$entityMap)
        );
    }
}
