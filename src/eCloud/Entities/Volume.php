<?php

namespace UKFast\SDK\eCloud\Entities;

use UKFast\SDK\Entity;

/**
 * @property string $id
 * @property string $name
 * @property string $vpcId
 * @property integer $capacity
 * @property integer $iops
 * @property boolean $attached
 * @property string $sync
 */
class Volume extends Entity
{
    protected $dates = ['createdAt', 'updatedAt'];
}
