<?php

namespace UKFast\SSL\Entities;

class Certificate
{
    public $id;

    public $name;
    public $status;

    public $commonName;
    public $alternativeNames;

    public $validDays;
    public $orderedDate;
    public $renewalDate;


    /**
     * Certificate constructor.
     * @param null $item
     */
    public function __construct($item = null)
    {
        if (empty($item)) {
            return;
        }

        $this->id = $item->id;

        $this->name = $item->name;
        $this->status = $item->status;

        $this->commonName = $item->common_name;
        $this->alternativeNames = $item->alternative_names;

        $this->validDays = $item->valid_days;
        $this->orderedDate = $item->ordered_date;
        $this->renewalDate = $item->renewal_date;
    }
}
