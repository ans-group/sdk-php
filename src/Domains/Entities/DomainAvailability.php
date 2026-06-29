<?php

namespace UKFast\SDK\Domains\Entities;

use UKFast\SDK\Entity;

/**
 * @property string $domain
 * @property bool $available
 * @property DomainAvailabilityTerm[] $terms
 */
class DomainAvailability extends Entity
{
    public function __construct($attributes = [])
    {
        if (is_object($attributes)) {
            $attributes = (array) $attributes;
        }

        if (isset($attributes['terms']) && is_array($attributes['terms'])) {
            $attributes['terms'] = array_map(function ($term) {
                return new DomainAvailabilityTerm((array) $term);
            }, $attributes['terms']);
        }

        parent::__construct($attributes);
    }
}
