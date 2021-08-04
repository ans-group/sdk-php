<?php

namespace UKFast\SDK\eCloud;

use UKFast\SDK\eCloud\Entities\VpnSession;
use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\Traits\PageItems;

class VpnSessionClient extends Client implements ClientEntityInterface
{
    use PageItems;

    protected $collectionPath = 'v2/vpn-sessions';

    public function getEntityMap()
    {
        return [
            'id' => 'id',
            'name' => 'name',
            'vpn_profile_group_id' => 'vpnProfileGroupId',
            'vpn_service_id' => 'vpnServiceId',
            'vpn_endpoint_id' => 'vpnEndpointId',
            'remote_ip' => 'remoteIp',
            'remote_networks' => 'remoteNetworks',
            'local_networks' => 'localNetworks',
            'sync' => 'sync',
            'created_at' => 'createdAt',
            'updated_at' => 'updatedAt',
        ];
    }

    public function loadEntity($data)
    {
        return new VpnSession(
            $this->apiToFriendly($data, $this->getEntityMap())
        );
    }
}
