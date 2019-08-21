<?php

namespace UKFast\SDK\LTaaS\Entities;

class Agreement
{
    /**
     * @var string
     */
    public $version;

    /**
     * @var string
     */
    public $agreement;

    public function __construct($item = null)
    {
        if (is_null($item)) {
            return;
        }

        $this->version = $item->version;
        $this->agreement = $item->agreement;
    }
}
