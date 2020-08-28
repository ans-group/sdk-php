<?php

namespace UKFast\SDK\eCloud\Entities;

use UKFast\SDK\Entity;

/**
 * @property string $id
 * @property string $vpcId
 * @property string $availabilityZoneId
 * @property string $name
 * @property string $configId
 * @property int $nodes
 *
 */
class LoadBalancerCluster extends Entity
{
    protected $dates = ['createdAt', 'updatedAt'];
}
