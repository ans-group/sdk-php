<?php

namespace UKFast\SDK\eCloud\Entities\VPC;

use UKFast\SDK\Entity;

/**
 * @property string $id
 * @property string $name
 * @property int $level
 * @property string $createdAt
 * @property string $updatedAt
 */
class Iops extends Entity
{
    protected $dates = ['createdAt', 'updatedAt'];

    public static $entityMap = [
        'id' => 'id',
        'name' => 'name',
        'level' => 'level',
        'created_at' => 'createdAt',
        'updated_at' => 'updatedAt',
    ];
}
