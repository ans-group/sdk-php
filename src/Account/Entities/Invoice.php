<?php

namespace UKFast\SDK\Account\Entities;

use DateTime;

class Invoice
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var \Datetime
     */
    public $date;

    /**
     * @var bool
     */
    public $paid;

    /**
     * @var float
     */
    public $amount;

    /**
     * Invoice constructor.
     *
     * @param null $item
     */
    public function __construct($item = null)
    {
        if (empty($item)) {
            return;
        }

        $this->id = $item->id;
        $this->date = DateTime::createFromFormat('Y-m-d', $item->date);
        $this->paid = $item->paid;
        $this->amount = $item->amount;
    }
}
