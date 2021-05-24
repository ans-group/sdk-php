<?php

namespace UKFast\SDK\eCloud\Entities;

use UKFast\SDK\Entity;

/**
 * @property string $id
 * @property string $vpcId
 * @property string $ipAddress
 * @property string $resourceId
 * @property string $createdAt
 * @property string $updatedAt
 */
class FloatingIp extends Entity
{
    protected $dates = ['createdAt', 'updatedAt'];
}
