<?php
/**
 * @author: John Birch-Evans <john.birch-evans@ukfast.co.uk>
 * @copyright: 2020 UKFast.net Ltd
 */

namespace UKFast\SDK\ThreatMonitoring\Entities;

use UKFast\SDK\Entity;

/**
 * @property integer $id
 * @property integer $scanId
 * @property \DateTime $scanStart
 * @property \DateTime $scanEnd
 * @property string $ip
 * @property string $fqdn
 * @property string $macAddress
 * @property string $os
 * @property integer $critical
 * @property integer $high
 * @property integer $medium
 * @property integer $low
 * @property integer $info
 * @property float $maxScore
 * @property Vulnerability[] $vulnerabilities
 */
class ScanResults extends Entity
{
}
