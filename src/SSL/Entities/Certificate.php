<?php

namespace UKFast\SDK\SSL\Entities;

use UKFast\SDK\Entity;

/**
 * @property $id
 * @property $name
 * @property $status
 * @property $commonName
 * @property $alternativeNames
 * @property $validDays
 * @property $orderedAt
 * @property $renewalAt
 */
class Certificate extends Entity
{
    /**
     * Dates to map to \DateTime objects
     *
     * @var array $dates
     */
    protected $dates = [
        'orderedAt',
        'renewalAt',
    ];
}
