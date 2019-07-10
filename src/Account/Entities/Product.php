<?php

namespace UKFast\SDK\Account\Entities;

class Product
{
    /**
     * @var integer
     */
    public $id;

    /**
     * @var string
     */
    public $value;

    /**
     * @var string
     */
    public $type;

    /**
     * Product constructor.
     * @param mixed $item
     */
    public function __construct($item = null)
    {
        if (empty($item)) {
            return;
        }

        $this->id = $item->id;
        $this->value = $item->value;
        $this->type = $item->type;
    }
}
