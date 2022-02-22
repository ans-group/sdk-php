<?php

namespace UKFast\SDK\eCloud\Entities;

use UKFast\SDK\Entity;

/**
 * @property string $id
 * @property string $name
 * @property string $ipAddress
 * @property string $networkId
 * @property string $createdAt
 * @property string $updatedAt
 */
class IpAddress extends Entity
{
    protected $dates = ['createdAt', 'updatedAt'];
}
