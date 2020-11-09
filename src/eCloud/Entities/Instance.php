<?php

namespace UKFast\SDK\eCloud\Entities;

use UKFast\SDK\Entity;

/**
 * @property string $id
 * @property string $name
 * @property string $vpcId
 * @property string $applianceId
 * @property string $platform
 * @property integer $vcpuCores
 * @property integer $ramCapacity
 * @property integer $volumeCapacity
 * @property boolean $locked
 * @property string $status
 * @property boolean $online
 * @property boolean $agentRunning
 * @property string $createdAt
 * @property string $updatedAt
 */
class Instance extends Entity
{
    protected $dates = ['createdAt', 'updatedAt'];
}
