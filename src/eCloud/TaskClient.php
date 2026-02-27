<?php

namespace UKFast\SDK\eCloud;

use UKFast\SDK\eCloud\Entities\Task;
use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\Traits\PageItems;

class TaskClient extends Client implements ClientEntityInterface
{
    /** @use PageItems<Task> */
    use PageItems;

    protected $collectionPath = 'v2/tasks';

    public function getEntityMap()
    {
        return [
            'id' => 'id',
            'resource_id' => 'resourceId',
            'name' => 'name',
            'status' => 'status',
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
