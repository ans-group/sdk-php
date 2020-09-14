<?php

namespace UKFast\SDK\eCloud\Entities;

use UKFast\SDK\Entity;

/**
 * @property string $id
 * @property string $vpcId
 * @property string $name
 */
class Instance extends Entity
{
    protected $dates = ['createdAt', 'updatedAt'];
}
