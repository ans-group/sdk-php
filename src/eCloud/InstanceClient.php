<?php

namespace UKFast\SDK\eCloud;

use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\Traits\PageItems;
use UKFast\SDK\eCloud\Entities\Instance;

class InstanceClient extends Client implements ClientEntityInterface
{
    use PageItems;

    protected $collectionPath = 'v2/instances';

    public function getEntityMap()
    {
        return [
            'id' => 'id',
            'name' => 'name',
            'vpc_id' => 'vpcId',
            'created_at' => 'createdAt',
            'updated_at' => 'updatedAt',
        ];
    }

    public function loadEntity($data)
    {
        return new Instance(
            $this->apiToFriendly($data, $this->getEntityMap())
        );
    }
}
