<?php

namespace UKFast\SDK\PSS\Entities;

class Attachment
{
    /**
     * @var string
     */
    public $name;

    /**
     * Attachment constructor.
     * @param $item
     */
    public function __construct($item)
    {
        $this->name = $item->name;
    }
}
