<?php

namespace UKFast\SSL;

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
}
