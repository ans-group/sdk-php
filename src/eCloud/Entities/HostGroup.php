<?php

namespace UKFast\SDK\eCloud\Entities;

use UKFast\SDK\Entity;

/**
 * @property string $id
 * @property string $name
 * @property string $vpcId
 * @property string $availabilityZoneId
 * @property string $specId
 * @property string $createdAt
 * @property string $updatedAt
 */
class HostGroup extends Entity
{
    protected $dates = ['createdAt', 'updatedAt'];
}
