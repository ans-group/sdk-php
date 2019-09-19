<?php

namespace UKFast\SDK\Account\Entities;

class Credit
{
    public $type;
    public $total;
    public $remaining;


    /**
     * Credit constructor.
     * @param null $item
     */
    public function __construct($item = null)
    {
        if (empty($item)) {
            return;
        }

        $this->type = $item->type;
        $this->total = $item->total;
        $this->remaining = $item->remaining;
    }
}
