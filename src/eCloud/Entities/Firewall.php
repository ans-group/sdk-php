<?php

namespace UKFast\SDK\eCloud\Entities;

class Firewall
{
    public $id;
    public $name;

    public $hostname;
    public $ipAddress;

    public $haRole;


    /**
     * Firewall constructor.
     * @param null $item
     */
    public function __construct($item = null)
    {
        if (empty($item)) {
            return;
        }

        $this->id = $item->id;
        $this->name = $item->name;

        $this->hostname = $item->hostname;
        $this->ipAddress = $item->ip;

        $this->haRole = $item->role;
    }
}
