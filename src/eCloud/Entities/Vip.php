<?php

namespace UKFast\SDK\eCloud\Entities;

use UKFast\SDK\Entity;

/**
 * @property string $id
 * @property string $name
 * @property string $loadBalancerNetworkId
 * @property string $ipAddressId
 * @property string $sync
 * @property string $createdAt
 * @property string $updatedAt
 */
class Vip extends Entity
{
    protected $dates = ['createdAt', 'updatedAt'];
}
