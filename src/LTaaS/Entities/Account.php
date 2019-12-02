<?php

namespace UKFast\SDK\LTaaS\Entities;

class Account
{
    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $resellerId;


    public function __construct($item = null)
    {
        if (is_null($item)) {
            return;
        }

        $this->id = $item->id;
        $this->resellerId = (isset($item->reseller_id)) ? $item->reseller_id : null;
    }
}
