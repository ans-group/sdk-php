<?php

namespace UKFast\SDK\eCloud;

use UKFast\SDK\eCloud\Entities\VpnEndpoint;
use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\Traits\PageItems;

class VpnEndpointClient extends Client implements ClientEntityInterface
{
    use PageItems;

    protected $collectionPath = 'v2/vpn-endpoints';

    public function getEntityMap()
    {
        return [
            'id' => 'id',
            'name' => 'name',
            'floating_ip_id' => 'floatingIpId',
            'vpn_service_id' => 'vpnServiceId',
            'created_at' => 'createdAt',
            'updated_at' => 'updatedAt',
        ];
    }

    public function loadEntity($data)
    {
        return new VpnEndpoint(
            $this->apiToFriendly($data, $this->getEntityMap())
        );
    }
}
