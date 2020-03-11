<?php
/**
 * @author: John Birch-Evans <john.birch-evans@ukfast.co.uk>
 * @copyright: 2020 UKFast.net Ltd
 */

namespace UKFast\SDK\ThreatMonitoring\Entities;

use UKFast\SDK\Entity;

/**
 * @property string $id
 * @property string $agentId
 * @property string $agentFriendlyName
 * @property integer $level
 * @property string $description
 * @property array $gdpr
 * @property array $pciDss
 * @property string $fullLog
 * @property string $timestamp
 */
class Alert extends Entity
{
}