<?php

namespace UKFast\SDK;

use DateTime;

abstract class Entity
{
    /**
     * @var array
     */
    protected $attributes = [];

    protected $dates = [];

    /**
     * @param array $attributes
     */
    public function __construct($attributes = [])
    {
        if (is_object($attributes)) {
            $attributes = (array) $attributes;
        }
        
        foreach ($attributes as $name => $value) {
            $this->set($name, $value);
        }
    }

    /**
     * Gets an attribute, if the attribute hasn't been
     * set yet, return $default
     *
     * @param string $attr
     * @param mixed $default
     * @return mixed
     */
    public function get($attr, $default = null)
    {
        if ($this->has($attr)) {
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
        if (in_array($attr, $this->dates)) {
            $value = DateTime::createFromFormat(DateTime::ISO8601, $value);
        }

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
            $this->set($name, $value);
        }
    }

    /**
     * Returns true if the attribute is present on the
     * entity
     * @param string $attribute
     * @return bool
     */
    public function has($attribute)
    {
        return isset($this->attributes[$attribute]);
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

        foreach ($arr as $name => $value) {
            if ($value instanceof Entity) {
                $arr[$name] = $arr[$name]->toArray();
            }
        }

        foreach ($map as $entityName => $apiName) {
            if (isset($arr[$entityName])) {
                $arr[$apiName] = $arr[$entityName];
                unset($arr[$entityName]);
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
     * Magic setter method. Proxies property access to
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

    /**
     * Allows an entity to work with isset() or empty()
     * Checks that the attribute has been set and that
     * the value is not null
     *
     * @return bool
     */
    public function __isset($key)
    {
        return !is_null($this->get($key));
    }
}
