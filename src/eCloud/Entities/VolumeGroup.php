<?php

namespace UKFast\SDK\eCloud\Entities;

use UKFast\SDK\Entity;

/**
 * @property string $id
 * @property string $name
 * @property string $vpcId
 * @property string $availabilityZoneId
 * @property string sync
 */
class VolumeGroup extends Entity
{
    protected $dates = ['createdAt', 'updatedAt'];
}
