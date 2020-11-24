<?php

namespace UKFast\SDK\eCloud\Entities;

use UKFast\SDK\Entity;

/**
 * @property string $id
 * @property string $ipAddress
 * @property string $macAddress
 * @property string $instanceId
 * @property string $networkId
 */
class Nic extends Entity
{
    protected $dates = ['createdAt', 'updatedAt'];
}
