<?php

namespace UKFast\SDK\eCloud;

use UKFast\SDK\eCloud\Entities\Task;
use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\Traits\PageItems;

class TaskClient extends Client implements ClientEntityInterface
{
    use PageItems;

    protected $collectionPath = 'v2/discount-plans';

    public function getEntityMap()
    {
        return [
            'id' => 'id',
            'resource_id' => 'resourceId',
            'name' => 'name',
            'data' => 'data',
            'completed' => 'completed',
            'created_at' => 'createdAt',
            'updated_at' => 'updatedAt',
        ];
    }

    public function loadEntity($data)
    {
        return new Task(
            $this->apiToFriendly($data, $this->getEntityMap())
        );
    }
}
