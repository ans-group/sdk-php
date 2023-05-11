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
 * @property boolean $isEncrypted
 * @property string $volumeGroupId
 * @property integer $port
 */
class Volume extends Entity
{
    protected $dates = ['createdAt', 'updatedAt'];
}
