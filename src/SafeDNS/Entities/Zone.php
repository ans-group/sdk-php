<?php

namespace UKFast\SDK\SafeDNS\Entities;

class Zone
{
    public $name;
    public $description;


    /**
     * Zone constructor.
     * @param null $item
     */
    public function __construct($item = null)
    {
        if (empty($item)) {
            return;
        }

        $this->name = $item->name;
        $this->description = $item->description;
    }
}
