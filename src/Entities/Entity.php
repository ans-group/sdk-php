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
