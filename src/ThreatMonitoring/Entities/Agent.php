<?php

namespace UKFast\SDK\ThreatMonitoring\Entities;

use UKFast\SDK\Entity;

/**
 * @property string $id
 * @property string $status
 * @property string $threatResponseEnabled
 * @property string $name
 * @property int $serverId
 * @property string $hostingType
 * @property string $osVersion
 * @property boolean $hasNessus
 * @property string $createdAt
 * @property string $updatedAt
 */
class Agent extends Entity
{
}
