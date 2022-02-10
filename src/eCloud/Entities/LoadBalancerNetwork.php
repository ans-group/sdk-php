<?php

namespace UKFast\SDK\eCloud\Entities;

use UKFast\SDK\Entity;

/**
 * @property string $id
 * @property string $name
 * @property string $loadBalancerId
 * @property string $networkId
 * @property string $sync
 * @property string $createdAt
 * @property string $updatedAt
 */
class LoadBalancerNetwork extends Entity
{
    protected $dates = ['createdAt', 'updatedAt'];
}
