<?php
/**
 * @author: John Birch-Evans <john.birch-evans@ukfast.co.uk>
 * @copyright: 2020 UKFast.net Ltd
 */

namespace UKFast\Admin\ThreatMonitoring\Entities;

use UKFast\SDK\Entity;

/**
 * @property string $id
 * @property string $status
 * @property bool $isTrial
 * @property bool $hasFreeTarget
 * @property \DateTime $createdAt
 * @property \DateTime $updatedAt
 */
class User extends Entity
{
}
