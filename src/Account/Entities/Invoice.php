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
    public $net;

    /**
     * @var float
     */
    public $vat;

    /**
     * @var float
     */
    public $gross;

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
        $this->net = $item->net;
        $this->vat = $item->vat;
        $this->gross = $item->gross;
    }
}
