<?php

namespace UKFast\SDK\eCloud\Entities;

class Hdd
{
    public $uuid;
    public $name;

    public $capacity;


    /**
     * Hdd constructor.
     * @param null $item
     */
    public function __construct($item = null)
    {
        if (empty($item)) {
            return;
        }

        $this->name = $item->name;
        $this->capacity = $item->capacity;

        if (isset($item->uuid)) {
            $this->uuid = $item->uuid;
        }
    }
}
