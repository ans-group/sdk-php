<?php

namespace UKFast\SDK\eCloud;

use UKFast\SDK\eCloud\Entities\VolumeGroup;
use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\Traits\PageItems;

class VolumeGroupClient extends Client implements ClientEntityInterface
{
    use PageItems;

    protected $collectionPath = 'v2/volume-groups';

    public function getEntityMap()
    {
        return [
            'id' => 'id',
            'name' => 'name',
            'vpc_id' => 'vpcId',
            'availability_zone_id' => 'availabilityZoneId',
            'sync' => 'sync',
            'usage' => 'usage',
            'created_at' => 'createdAt',
            'updated_at' => 'updatedAt',
        ];
    }

    public function loadEntity($data)
    {
        return new VolumeGroup(
            $this->apiToFriendly($data, $this->getEntityMap())
        );
    }
}
