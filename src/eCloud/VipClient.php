<?php

namespace UKFast\SDK\eCloud;

use UKFast\SDK\eCloud\Entities\Vip;
use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\Traits\PageItems;

class VipClient extends Client implements ClientEntityInterface
{
    use PageItems;

    protected $collectionPath = 'v2/vips';

    public function getEntityMap()
    {
        return [
            'id' => 'id',
            'name' => 'name',
            'load_balancer_network_id' => 'loadBalancerNetworkId',
            'ip_address_id' => 'ipAddressId',
            'config_id' => 'configId',
            'sync' => 'sync',
            'created_at' => 'createdAt',
            'updated_at' => 'updatedAt',
        ];
    }

    public function loadEntity($data)
    {
        return new Vip(
            $this->apiToFriendly($data, $this->getEntityMap())
        );
    }
}
