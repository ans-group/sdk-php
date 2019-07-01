<?php

namespace UKFast\SDK\eCloud\Entities;

class Solution
{
    public $id;
    public $name;

    public $environment;
    public $podId;


    /**
     * Solution constructor.
     * @param null $item
     */
    public function __construct($item = null)
    {
        if (empty($item)) {
            return;
        }

        $this->id = $item->id;
        $this->name = $item->name;

        $this->environment = $item->environment;
        $this->podId = $item->pod_id;
    }
}
