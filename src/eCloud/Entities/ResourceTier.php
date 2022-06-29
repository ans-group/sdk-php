<?php

namespace UKFast\SDK\eCloud\Entities;

use UKFast\SDK\Entity;

/**
 * @property int $id
 * @property string $name
 * @property string $availabilityZoneId
 * @property string $createdAt
 * @property string $updatedAt
 */
class ResourceTier extends Entity
{
    protected $dates = ['createdAt', 'updatedAt'];

    public static $entityMap = [
        'id' => '$id',
        'name' => '$name',
        'availability_zone_id' => '$availabilityZoneId',
        'created_at' => 'createdAt',
        'updated_at' => 'updatedAt',
    ];
}
