<?php

namespace UKFast\SDK\eCloud\Entities;

use UKFast\SDK\Entity;

/**
 * @property string $id
 * @property string $name
 * @property string $instanceId
 * @property string $softwareId
 * @property string $sync
 * @property string $task
 * @property \DateTime $createdAt
 * @property \DateTime $updatedAt
 */
class InstanceSoftware extends Entity
{
    protected $dates = ['createdAt', 'updatedAt'];

    public static $entityMap = [
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
