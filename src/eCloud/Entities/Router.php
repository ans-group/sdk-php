<?php

namespace UKFast\SDK\eCloud\Entities;

use UKFast\SDK\Entity;

/**
 * @property string $id
 * @property string $name
 * @property string $vpcId
 * @property string $availabilityZoneId
 * @property string $throughputId
 * @property string $sync
 */
class Router extends Entity
{
    protected $dates = ['createdAt', 'updatedAt'];
}
