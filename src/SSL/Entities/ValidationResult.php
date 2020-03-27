<?php

namespace UKFast\SDK\SSL\Entities;

use DateTime;
use UKFast\SDK\Entity;

/**
 * @property array $domains
 * @property DateTime $expiresAt
 */
class ValidationResult extends Entity
{
    /**
     * Dates to map to \DateTime objects
     *
     * @var array $dates
     */
    protected $dates = [
        'expiresAt'
    ];
}
