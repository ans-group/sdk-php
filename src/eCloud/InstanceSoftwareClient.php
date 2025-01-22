<?php

namespace UKFast\SDK\eCloud;

use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\Traits\PageItems;
use UKFast\SDK\eCloud\Entities\InstanceSoftware;

class InstanceSoftwareClient extends Client implements ClientEntityInterface
{
    use PageItems;

    protected $collectionPath = 'v2/instance-software';

    public function getEntityMap()
    {
        return [
            'id' => 'id',
            'name' => 'name',
            'instance_id' => 'instanceId',
            'software_id' => 'softwareId',
            'sync' => 'sync',
            'task' => 'task',
            'created_at' => 'createdAt',
            'updated_at' => 'updatedAt',
        ];
    }

    public function loadEntity($data)
    {
        return new InstanceSoftware(
            $this->apiToFriendly($data, $this->getEntityMap())
        );
    }
}
