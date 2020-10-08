<?php

namespace UKFast\SDK\eCloud\Entities;

use UKFast\SDK\Entity;

/**
 * @property string $id
 * @property string $name
 * @property string $vpcId
 * @property string $applianceId
 * @property boolean $locked
 * @property integer $vcpuCores
 * @property integer $ramCapacity
 * @property integer $volumeCapacity
 */
class Instance extends Entity
{
    protected $dates = ['createdAt', 'updatedAt'];
}
