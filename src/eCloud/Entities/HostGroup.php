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
 * @property object $usage
 * @property object $hostLimits
 * @property object $sync
 * @property object $task
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
        'usage' => 'usage',
        'host_limits' => 'hostLimits',
        'sync' => 'sync',
        'task' => 'task',
        'created_at' => 'createdAt',
        'updated_at' => 'updatedAt',
    ];
}
