<?php

namespace UKFast\SDK\eCloud\Entities;

use UKFast\SDK\Entity;

/**
 * @property string $id
 * @property string $name
 * @property string $vpcId
 * @property integer $capacity
 */
class Volume extends Entity
{
    protected $dates = ['createdAt', 'updatedAt'];
}
