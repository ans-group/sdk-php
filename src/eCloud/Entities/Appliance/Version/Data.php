<?php

namespace UKFast\SDK\eCloud\Entities\Appliance\Version;

class Data
{
    public $key;
    public $value;

    /**
     * Solution constructor.
     * @param null $item
     */
    public function __construct($item = null)
    {
        if (empty($item)) {
            return;
        }

        $this->key = $item->key;
        $this->value = $item->value;
    }
}
