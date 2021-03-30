<?php

namespace UKFast\SDK\eCloud;

use UKFast\SDK\eCloud\Entities\DedicatedHost;
use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\Traits\PageItems;

class DedicatedHostClient extends Client implements ClientEntityInterface
{
    use PageItems;

    protected $collectionPath = 'v2/hosts';

    public function getEntityMap()
    {
        return [
            'id' => 'id',
            'name' => 'name',
            'vpc_id' => 'vpcId',
            'host_group_id' => 'groupId',
            'sync' => 'sync',
            'created_at' => 'createdAt',
            'updated_at' => 'updatedAt',
        ];
    }

    public function loadEntity($data)
    {
        return new DedicatedHost(
            $this->apiToFriendly($data, $this->getEntityMap())
        );
    }

    public function getInstances($id)
    {
        return $this->instances()->getByVolumeId($id);
    }
}
