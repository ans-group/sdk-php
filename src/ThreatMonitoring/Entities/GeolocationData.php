<?php
/**
 * @author: John Birch-Evans <john.birch-evans@ukfast.co.uk>
 * @copyright: 2020 UKFast.net Ltd
 */

namespace UKFast\SDK\ThreatMonitoring\Entities;

use UKFast\SDK\Entity;

/**
 * @property string $key
 * @property integer $count
 * @property AttackCoordinates $location
 */
class GeolocationData extends Entity
{
}
