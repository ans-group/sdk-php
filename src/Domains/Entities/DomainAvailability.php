<?php

namespace UKFast\SDK\Domains\Entities;

use UKFast\SDK\Entity;

/**
 * @property string $domain
 * @property bool $available
 * @property string $tier "standard" or "premium"
 * @property bool $premium Deprecated, use $tier or isPremium(). Kept readable for older API responses.
 * @property DomainAvailabilityTerm[] $terms
 */
class DomainAvailability extends Entity
{
    public function __construct($attributes = [])
    {
        if (is_object($attributes)) {
            $attributes = (array) $attributes;
        }

        // The API used to return a premium boolean and now returns a tier. Accept either, and keep both readable.
        if (isset($attributes['tier'])) {
            $attributes['premium'] = $attributes['tier'] === 'premium';
        } elseif (array_key_exists('premium', $attributes)) {
            $attributes['tier'] = $attributes['premium'] ? 'premium' : 'standard';
        }

        if (isset($attributes['terms']) && is_array($attributes['terms'])) {
            $attributes['terms'] = array_map(function ($term) {
                return new DomainAvailabilityTerm((array) $term);
            }, $attributes['terms']);
        }

        parent::__construct($attributes);
    }

    /**
     * @return bool
     */
    public function isPremium()
    {
        return $this->tier === 'premium';
    }
}
