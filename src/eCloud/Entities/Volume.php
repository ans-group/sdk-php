<?php

namespace UKFast\SDK\eCloud\Entities;

use UKFast\SDK\Entity;

/**
 * @property string $id
 * @property string $name
 * @property string $vpcId
 * @property string $availabilityZoneId
 * @property integer $capacity
 * @property integer $iops
 * @property boolean $attached
 * @property string $sync
 * @property boolean $isShared
 * @property bool $isPrivate
 * @property boolean $isEncrypted
 * @property string $volumeGroupId
 * @property integer $port
 */
class Volume extends Entity
{
    protected $dates = ['createdAt', 'updatedAt'];
    public static $entityMap = [
        'id' => 'id',
        'name' => 'name',
        'vpc_id' => 'vpcId',
        'availability_zone_id' => 'availabilityZoneId',
        'capacity' => 'capacity',
        'iops' => 'iops',
        'attached' => 'attached',
        'sync' => 'sync',
        'created_at' => 'createdAt',
        'updated_at' => 'updatedAt',
        'is_shared' => 'isShared',
        'is_private' => 'isPrivate',
        'is_encrypted' => 'isEncrypted',
        'volume_group_id' => 'volumeGroupId',
        'port' => 'port',
    ];
}
