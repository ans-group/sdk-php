<?php

namespace UKFast\SDK\Entities;

abstract class Entity
{
    /**
     * @var array
     */
    protected $attributes = [];

    /**
     * @param array $attributes
     */
    public function __construct($attributes = [])
    {
        $this->attributes = $attributes;
    }

    /**
     * Gets an attribute, if the attribute hasn't been
     * set yet, return null
     * 
     * @param string $attr
     * @param mixed $default
     * @return mixed
     */
    public function get($attr, $default = null)
    {
        if (isset($this->attributes[$attr])) {
            return $this->attributes[$attr];
        }

        return $default;
    }


    /**
     * Sets an attribute
     * 
     * @param string $attr
     * @param mixed $value
     * @return void
     */
    public function set($attr, $value)
    {
        $this->attributes[$attr] = $value;
    }

    /**
     * @return array
     */
    public function all()
    {
        return $this->attributes;
    }

    /**
     * Hydrates an entity
     * 
     * @param array $attributes
     * @return void
     */
    public function fill($attributes)
    {
        foreach ($attributes as $name => $value) {
            $this->attributes[$name] = $value;
        }
    }

    public function has($attribute)
    {
        return isset($this->attributes[$attribute]);
    }

    /**
     * Fills in all the properties for an entity based off
     * the provided raw response. Can pass an optional
     * third argument to map API names to entity names
     * e.g. ['not_nice_api_name' => 'niceEntityName']
     * 
     * @param object $raw
     * @param array $map
     * @return void
     */
    public function hydrate(object $raw, $map = [])
    {
        foreach ($map as $rawName => $entityName) {
            if (isset($raw->{$rawName})) {
                $raw->{$entityName} = $raw->{$rawName};
                unset($raw->{$rawName});
            }
        }

        foreach ($raw as $prop => $value) {
            if (!$this->has($prop)) {
                $this->set($prop, $value);
            }
        }
    }

    /**
     * Returns an array representation of the the entity.
     * Can pass a map of property names to array names
     * e.g. ['createdAt' => 'created_at']
     * 
     * @param array $map
     * @return array
     */
    public function toArray($map = [])
    {
        $arr = $this->all();
        foreach ($this->readOnly as $readOnly) {
            unset($arr[$readOnly]);
        }

        foreach ($arr as $name => $value) {
            if ($value instanceof Entity) {
                unset($arr[$name]);
            }
        }

        return $arr;
     }

    /**
     * Magic getter method. Proxies property access to
     * internal array of attributes
     * 
     * @param string $attr
     * @return mixed
     */
    public function __get($attr)
    {
        return $this->get($attr);
    }

    /**
     * 
     * Magic getter method. Proxies property access to
     * internal array of attributes
     * 
     * @param string $attr
     * @param mixed $value
     * @return void
     */
    public function __set($attr, $value)
    {
        $this->set($attr, $value);
    }
}
