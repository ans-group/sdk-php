<?php

namespace UKFast\SDK\Billing\Entities;

use UKFast\SDK\Entity;

/**
 * @property string $type
 * @property int $quantity
 * @property int $price
 * @property string $period
 * @property int $usageSinceLastInvoice
 * @property float $costSinceLastInvoice
 * @property int $usageForPeriodEstimate
 * @property float $costForPeriodEstimate
 * @property \DateTime $billingStart
 * @property \DateTime $billingEnd
 * @property \DateTime $billingDueDate
 */
class Resource extends Entity
{
    //
}
