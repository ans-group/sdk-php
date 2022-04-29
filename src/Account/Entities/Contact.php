<?php

namespace UKFast\SDK\Account\Entities;

class Contact
{
    public $id;
    public $type;

    public $firstName;
    public $lastName;
    public $emailAddress;

    /**
     * Contact constructor.
     * @param \stdClass|null $item
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
        $this->emailAddress = $item->email_address;
    }

    /**
     * @return string
     */
    public function fullName()
    {
        return $this->firstName . ' ' . $this->lastName;
    }
}
