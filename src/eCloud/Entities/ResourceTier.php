<?php

namespace UKFast\SDK\eCloud\Entities;

use UKFast\SDK\Entity;

/**
 * @property string $id
 * @property string $name
 * @property string $description
 * @property string $availabilityZoneId
 * @property object $cpu
 * @property object $cpuSockets
 * @property object $ram
 * @property string $createdAt
 * @property string $updatedAt
 */
class ResourceTier extends Entity
{
    protected $dates = ['createdAt', 'updatedAt'];

    public static $entityMap = [
        'id' => 'id',
        'name' => 'name',
        'description' => 'description',
        'availability_zone_id' => 'availabilityZoneId',
        'cpu' => 'cpu',
        'cpu_sockets' => 'cpuSockets',
        'ram' => 'ram',
        'created_at' => 'createdAt',
        'updated_at' => 'updatedAt',
    ];
}
