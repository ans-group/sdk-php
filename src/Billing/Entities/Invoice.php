<?php

namespace UKFast\SDK\Billing\Entities;

use UKFast\SDK\Entity;

/**
 * @property int $id
 * @property \DateTime $date
 * @property boolean $paid
 * @property float $gross
 * @property float $vat
 * @property float $net
 */
class Invoice extends Entity
{
    protected $dates = ['date'];
}
