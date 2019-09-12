<?php

namespace UKFast\SDK\Entities;

abstract class Entity
{
    /**
     * Entity hydration blacklist.
     * @var array
     */
    protected $guarded = [];

    /**
     * Datastore constructor.
     * @param array $properties
     */
    public function __construct(array $properties = [])
    {
        $this->fill($properties);
    }

    /**
     * Fill the object properties (except for guarded)
     * @param array $properties
     */
    public function fill(array $properties)
    {
        foreach (array_diff_key($properties, array_flip($this->guarded)) as $property => $value) {
            if (property_exists($this, $property)) {
                $this->$property = $value;
            }
        }
    }
}
