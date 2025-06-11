<?php

namespace UKFast\SDK\eCloud;

use UKFast\SDK\eCloud\Entities\VpnService;
use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\Traits\PageItems;

class VpnServiceClient extends Client implements ClientEntityInterface
{
    /** @use PageItems<VpnService> */
    use PageItems;

    protected $collectionPath = 'v2/vpn-services';

    public function getEntityMap()
    {
        return [
            'id' => 'id',
            'name' => 'name',
            'router_id' => 'routerId',
            'vpc_id' => 'vpcId',
            'sync' => 'sync',
            'created_at' => 'createdAt',
            'updated_at' => 'updatedAt',
        ];
    }

    public function loadEntity($data)
    {
        return new VpnService(
            $this->apiToFriendly($data, $this->getEntityMap())
        );
    }
}
