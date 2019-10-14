<?php

namespace UKFast\SDK\PSS\Entities;

class Product
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $type;

    /**
     * Product constructor.
     * @param $item
     */
    public function __construct($item = null)
    {
        if (is_null($item)) {
            return;
        }
        
        $this->id = $item->id;
        $this->type = $item->type;
    }
}
