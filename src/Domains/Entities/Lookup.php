<?php

namespace UKFast\SDK\Domains\Entities;

use DateTime;
use UKFast\SDK\Entity;

/**
 * @property string $name
 * @property string $status
 * @property LookupRegistrar $registrar
 * @property LookupRegistry $registry
 * @property LookupNameserver[] $nameservers
 * @property DateTime|null $createdAt
 * @property DateTime|null $updatedAt
 * @property DateTime|null $expiresAt
 */
class Lookup extends Entity
{
    /**
     * Dates to map to \DateTime objects
     *
     * @var array $dates
     */
    protected $dates = [
        'createdAt',
        'updatedAt',
        'expiresAt',
    ];

    /**
     * Lookup constructor.
     * @param array $attributes
     */
    public function __construct($attributes = [])
    {
        if (is_object($attributes)) {
            $attributes = (array) $attributes;
        }

        if (isset($attributes['registrar'])) {
            $attributes['registrar'] = new LookupRegistrar((array) $attributes['registrar']);
        }

        if (isset($attributes['registry'])) {
            $attributes['registry'] = new LookupRegistry((array) $attributes['registry']);
        }

        if (isset($attributes['nameservers']) && is_array($attributes['nameservers'])) {
            $attributes['nameservers'] = array_map(function ($nameserver) {
                return new LookupNameserver((array) $nameserver);
            }, $attributes['nameservers']);
        }

        parent::__construct($attributes);
    }
}
