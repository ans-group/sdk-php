<?php

namespace UKFast\Domains\Entities;

class Nameserver
{
    public $host;
    public $ip;


    /**
     * Nameserver constructor.
     * @param null $item
     */
    public function __construct($item = null)
    {
        if (empty($item)) {
            return;
        }

        $this->host = $item->host;
        $this->ip = $item->ip;
    }
}
