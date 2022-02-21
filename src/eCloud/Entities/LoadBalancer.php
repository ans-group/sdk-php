<?php

namespace UKFast\SDK\eCloud\Entities;

use UKFast\SDK\Entity;

/**
 * @property string $id
 * @property string $name
 * @property string $vpcId
 * @property string $availabilityZoneId
 * @property string $networkId
 * @property string $specId
 * @property int $configId
 * @property string $sync
 * @property string $createdAt
 * @property string $updatedAt
 *
 */
class LoadBalancer extends Entity
{
    protected $dates = ['createdAt', 'updatedAt'];
}
