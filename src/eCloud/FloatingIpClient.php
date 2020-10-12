<?php

namespace UKFast\SDK\eCloud;

use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\Traits\PageItems;
use UKFast\SDK\eCloud\Entities\FloatingIp;

class FloatingIpClient extends Client implements ClientEntityInterface
{
    use PageItems;

    protected $collectionPath = 'v2/floating-ips';

    public function getEntityMap()
    {
        return [
            'id' => 'id',
            'vpc_id' => 'vpcId',
            'ip_address' => 'ipAddress',
            'created_at' => 'createdAt',
            'updated_at' => 'updatedAt',
        ];
    }

    public function loadEntity($data)
    {
        return new FloatingIp(
            $this->apiToFriendly($data, $this->getEntityMap())
        );
    }
}
