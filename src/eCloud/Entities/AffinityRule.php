<?php

namespace UKFast\SDK\eCloud\Entities;

use UKFast\SDK\Entity;

/**
 * @property int $id
 * @property string $name
 * @property string $vpcId
 * @property string $availabilityZoneId
 * @property string $type
 * @property string $createdAt
 */
class AffinityRule extends Entity
{
    protected $dates = ['createdAt', 'updatedAt'];

    public static $entityMap = [
        'id' => 'id',
        'name' => 'name',
        'vpc_id' => 'vpcId',
        'availability_zone_id' => 'availabilityZoneId',
        'type' => 'type',
        'created_at' => 'createdAt',
        'updated_at' => 'updatedAt',
    ];
}
