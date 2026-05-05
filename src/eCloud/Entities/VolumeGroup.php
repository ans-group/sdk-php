<?php

namespace UKFast\SDK\eCloud\Entities;

use UKFast\SDK\Entity;

/**
 * @property string $id
 * @property string $name
 * @property string $vpcId
 * @property string $availabilityZoneId
 * @property bool $isPrivate
 * @property string sync
 * @property object $usage
 */
class VolumeGroup extends Entity
{
    protected $dates = ['createdAt', 'updatedAt'];
    public static $entityMap = [
        'id' => 'id',
        'name' => 'name',
        'vpc_id' => 'vpcId',
        'availability_zone_id' => 'availabilityZoneId',
        'is_private' => 'isPrivate',
        'sync' => 'sync',
        'usage' => 'usage',
        'created_at' => 'createdAt',
        'updated_at' => 'updatedAt',
    ];
}
