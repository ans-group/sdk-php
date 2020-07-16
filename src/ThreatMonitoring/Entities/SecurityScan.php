<?php
/**
 * @author: John Birch-Evans <john.birch-evans@ukfast.co.uk>
 * @copyright: 2020 UKFast.net Ltd
 */

namespace UKFast\SDK\ThreatMonitoring\Entities;

use UKFast\SDK\Entity;

/**
 * @property integer $id
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
