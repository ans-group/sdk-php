<?php
/**
 * @author: John Birch-Evans <john.birch-evans@ukfast.co.uk>
 * @copyright: 2021 UKFast.net Ltd
 */

namespace UKFast\SDK\ThreatMonitoring\Entities;

use UKFast\SDK\Entity;

/**
 * @property string $fullLog
 * @property string $sourceUser
 * @property string $targetUser
 * @property ReportAgentDetails $agent
 * @property \DateTime $timestamp
 */
class LoginRecord extends Entity
{
}
