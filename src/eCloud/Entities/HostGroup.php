<?php

namespace UKFast\SDK\eCloud\Entities;

use UKFast\SDK\Entity;

/**
 * @property string $id
 * @property string $name
 * @property string $vpcId
 * @property string $availabilityZoneId
 * @property string $specId
 * @property string $windowsEnabled
 * @property string $sync
 * @property string $createdAt
 * @property string $updatedAt
 */
class HostGroup extends Entity
{
    protected $dates = ['createdAt', 'updatedAt'];

    public static $entityMap = [
        'id' => 'id',
        'name' => 'name',
        'vpc_id' => 'vpcId',
        'availability_zone_id' => 'availabilityZoneId',
        'host_spec_id' => 'specId',
        'windows_enabled' => 'windowsEnabled',
        'sync' => 'sync',
        'created_at' => 'createdAt',
        'updated_at' => 'updatedAt',
    ];
}
