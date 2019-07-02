<?php

namespace UKFast\SDK\PHaaS\Entities;

class CampaignUserResults
{
    public $firstName;
    public $lastName;
    public $position;
    public $email;
    public $status;

    /**
     * CampaignUserResults constructor.
     * @param $item
     */
    public function __construct($item)
    {
        $this->firstName = $item->first_name;
        $this->lastName = $item->last_name;
        $this->position = $item->position;
        $this->email = $item->email;
        $this->status = $item->status;
    }
}
