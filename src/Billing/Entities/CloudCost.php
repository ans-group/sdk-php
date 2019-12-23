<?php

namespace UKFast\SDK\Billing\Entities;

use UKFast\SDK\Entity;

/**
 * @property int $id
 * @property int $serverId
 * @property \DateTime $startAt
 * @property \DateTime $endAt
 * @property Resource $resource
 * @property string $period
 * @property float $price
 * @property \DateTime $nextPaymentOn
 * @property \DateTime $lastPaymentAt
 */
class CloudCost extends Entity
{
    protected $dates = ['startAt', 'endAt', 'nextPaymentOn', 'lastPaymentAt'];
}
