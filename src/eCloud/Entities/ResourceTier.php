<?php

namespace UKFast\SDK\eCloud\Entities;

use UKFast\SDK\Entity;

/**
 * @property string $id
 * @property string $name
 * @property string $availabilityZoneId
 * @property int $minRam
 * @property int $maxRam
 * @property int $minVcpu
 * @property int $maxVcpu
 * @property string $createdAt
 * @property string $updatedAt
 */
class ResourceTier extends Entity
{
    protected $dates = ['createdAt', 'updatedAt'];

    public static $entityMap = [
        'id' => 'id',
        'name' => 'name',
        'availability_zone_id' => 'availabilityZoneId',
        'min_ram' => 'minRam',
        'max_ram' => 'maxRam',
        'min_vcpu' => 'minVcpu',
        'max_vcpu' => 'maxVcpu',
        'created_at' => 'createdAt',
        'updated_at' => 'updatedAt',
    ];
}
