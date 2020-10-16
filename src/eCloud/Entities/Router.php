<?php

namespace UKFast\SDK\eCloud\Entities;

use UKFast\SDK\Entity;

/**
 * @property string $id
 * @property string $name
 * @property string $vpcId
 */
class Router extends Entity
{
    protected $dates = ['createdAt', 'updatedAt'];
}
