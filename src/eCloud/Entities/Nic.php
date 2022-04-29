<?php

namespace UKFast\SDK\eCloud\Entities;

use UKFast\SDK\Entity;

/**
 * @property string $id
 * @property string $name
 * @property string $ipAddress
 * @property string $macAddress
 * @property string $instanceId
 * @property string $networkId
 * @property string $sync
 */
class Nic extends Entity
{
    protected $dates = ['createdAt', 'updatedAt'];
}
