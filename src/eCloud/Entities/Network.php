<?php

namespace UKFast\SDK\eCloud\Entities;

use UKFast\SDK\Entity;

/**
 * @property string $id
 * @property string $name
 * @property string $vpcId
 * @property string $routerId
 * @property string $subnet
 * @property string $createdAt
 * @property string $updatedAt
 */
class Network extends Entity
{
    protected $dates = ['createdAt', 'updatedAt'];
}
