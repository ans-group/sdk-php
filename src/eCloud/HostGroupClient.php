<?php

namespace UKFast\SDK\eCloud;

use UKFast\SDK\eCloud\Entities\HostGroup;
use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\Traits\PageItems;

class HostGroupClient extends Client implements ClientEntityInterface
{
    use PageItems;

    protected $collectionPath = 'v2/host-groups';

    public function getEntityMap()
    {
        return [
            'id' => 'id',
            'name' => 'name',
            'vpc_id' => 'vpcId',
            'availability_zone_id' => 'availabilityZoneId',
            'host_spec_id' => 'specId',
            'created_at' => 'createdAt',
            'updated_at' => 'updatedAt',
        ];
    }

    public function loadEntity($data)
    {
        return new HostGroup(
            $this->apiToFriendly($data, $this->getEntityMap())
        );
    }
}
