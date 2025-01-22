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
    /**
     * @var array
     */
    protected $dates = ['createdAt', 'updatedAt'];
}
