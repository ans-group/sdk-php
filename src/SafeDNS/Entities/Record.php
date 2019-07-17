<?php

namespace UKFast\SDK\SafeDNS\Entities;

class Record
{
    public $id;
    public $zone;

    public $name;
    public $type;
    public $content;

    public $ttl;
    public $priority;


    /**
     * Record constructor.
     * @param null $item
     */
    public function __construct($item = null)
    {
        if (empty($item)) {
            return;
        }

        $this->id = $item->id;
        $this->zone = $item->zone;

        $this->name = $item->name;
        $this->type = $item->type;
        $this->content = $item->content;

        $this->ttl = $item->ttl;
        $this->priority = $item->priority;
    }
}
