<?php

namespace UKFast\SDK\eCloud\Entities;

use UKFast\SDK\Entity;

/**
 * @property string $id
 * @property string $name
 * @property string description
 */
class VpnProfileGroup extends Entity
{
    protected $dates = ['createdAt', 'updatedAt'];
}
