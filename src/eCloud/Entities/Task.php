<?php

namespace UKFast\SDK\eCloud\Entities;

use UKFast\SDK\Entity;

/**
 * Class Task
 * @property string $id
 * @property string $resourceId
 * @property string $resourceType
 * @property string $name
 * @property string $data
 * @property boolean $completed
 * @property string $createdAt
 * @property string $updatedAt
 */
class Task extends Entity
{
    protected $dates = ['createdAt', 'updatedAt'];
}
