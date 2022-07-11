<?php

namespace UKFast\SDK;

use ArrayAccess;
use DateTime;

abstract class Entity implements ArrayAccess
{
    /**
     * @var array
     */
    protected $attributes = [];
    protected $originalAttributes = [];

    protected $dates = [];

    /**
     * @param array $attributes
     */
    public function __construct($attributes = [])
    {
        if (is_object($attributes)) {
            $attributes = (array) $attributes;
        }

        $this->fill($attributes);
        $this->syncOriginalAttributes();
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

    /**
     * @inheritDoc
     */
    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->attributes);
    }

    /**
     * @inheritDoc
     */
    public function offsetGet($offset)
    {
        return $this->attributes[$offset];
    }

    /**
     * @inheritDoc
     */
    public function offsetSet($offset, $value)
    {
        $this->attributes[$offset] = $value;
    }

    /**
     * @inheritDoc
     */
    public function offsetUnset($offset)
    {
        unset($this->attributes[$offset]);
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
            $datetime = DateTime::createFromFormat(DateTime::ATOM, $value);
            if (!$datetime) {
                $datetime = DateTime::createFromFormat(DateTime::ISO8601, $value);
            }
            if (!$datetime) {
                $datetime = DateTime::createFromFormat('Y-m-d', $value);
            }
            if (!$datetime) {
                $datetime = null;
            }

            $value = $datetime;
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
     * Returns an array representation of the entity.
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
     * Clones an entity and all nested entities
     * Useful if you need to operate on a copy of an entity
     * and not worry about mutating anything in the original
     * @return Entity
     */
    public function copy()
    {
        $clone = function ($data) use (&$clone) {
            if (is_array($data)) {
                $new = [];
                foreach ($data as $datum) {
                    $new[] = $clone($datum);
                }
                return $new;
            }
            if ($data instanceof Entity) {
                return $data->copy();
            }
            return $data;
        };
        $cloned = [];
        foreach ($this->all() as $key => $value) {
            $cloned[$key] = $clone($value);
        }
        return new static($cloned);
    }

    /**
     * Sync the original attributes with current
     * @return void
     */
    public function syncOriginalAttributes()
    {
        $this->originalAttributes = $this->attributes;
    }

    /**
     * Determine if the entity has changes
     * @return bool
     */
    public function isDirty()
    {
        return !empty($this->getDirty());
    }

    /**
     * Determine if the entity has no changes
     * @return bool
     */
    public function isClean()
    {
        return !$this->isDirty();
    }

    /**
     * Get attributes that have changed since last sync
     *
     * @return array
     */
    public function getDirty()
    {
        $dirty = [];

        foreach ($this->attributes as $key => $value) {
            if (!array_key_exists($key, $this->originalAttributes) ||
                $value !== $this->originalAttributes[$key]
            ) {
                $dirty[$key] = $value;
            }
        }

        return $dirty;
    }
}
