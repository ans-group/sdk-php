<?php

namespace UKFast\SDK\Account\Entities;

class Contact
{
    public $id;
    public $type;

    public $firstName;
    public $lastName;
    public $fullName;

    public $emailAddress;

    /**
     * Contact constructor.
     * @param null $item
     */
    public function __construct($item = null)
    {
        if (empty($item)) {
            return;
        }

        $this->id = $item->id;
        $this->type = $item->type;

        $this->firstName = $item->first_name;
        $this->lastName = $item->last_name;
        $this->fullName = $this->firstName . ' ' . $this->lastName;

        $this->emailAddress = $item->email_address;
    }
}
