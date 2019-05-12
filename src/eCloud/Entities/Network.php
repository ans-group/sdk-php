<?php

namespace UKFast\eCloud\Entities;

class Network
{
    public $id;
    public $name;


    /**
     * Network constructor.
     * @param null $item
     */
    public function __construct($item = null)
    {
        if (empty($item)) {
            return;
        }

        $this->id = $item->id;
        $this->name = $item->name;
    }
}
