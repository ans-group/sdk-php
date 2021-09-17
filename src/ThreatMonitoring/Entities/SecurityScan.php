<?php

namespace UKFast\SDK\ThreatMonitoring\Entities;

use UKFast\SDK\Entity;

/**
 * @property integer $id
 * @property string $name
 * @property string $type
 * @property string $target
 * @property string $status
 * @property \DateTime $scheduled
 * @property \DateTime $scanStart
 * @property \DateTime $scanEnd
 * @property double $maxScore
 */
class SecurityScan extends Entity
{
}
