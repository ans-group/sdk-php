<?php

namespace UKFast\SDK\eCloud\Entities;

use UKFast\SDK\Entity;

/**
 * @property string $id
 * @property string $name
 * @property string $policyId
 * @property string $serviceType
 * @property string $source
 * @property string $sourcePorts
 * @property string $destination
 * @property string $destinationPorts
 * @property string $action
 * @property string $direction
 * @property int $sequence
 * @property bool $enabled
 * @property string $createdAt
 * @property string $updatedAt
 */
class FirewallRule extends Entity
{
    protected $dates = ['createdAt', 'updatedAt'];
}
