<?php

namespace UKFast\SDK\Traits\Entity;

trait NamedProperties
{
    protected $namedProperties = [];

    public function __construct()
    {
        $args = func_get_args();
        if (empty($args[0])) {
            return parent::__construct(...$args);
        }

        $reflectionClass = new \ReflectionClass(get_called_class());
        preg_match_all(
            '/@property\s.*\$(.*)\r?\n/m',
            $reflectionClass->getDocComment(),
            $matches
        );
        $this->namedProperties = $matches[1];

        if (!empty($this->namedProperties)) {
            $attributes = $args[0];

            foreach ($attributes as $key => $value) {
                if (!in_array($key, $this->namedProperties)) {
                    if (is_object($attributes)) {
                        unset($attributes->$key);
                    } else {
                        unset($attributes[$key]);
                    }
                }
            }

            $args[0] = $attributes;
        }

        return parent::__construct(...$args);
    }
}
