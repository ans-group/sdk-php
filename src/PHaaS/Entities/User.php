<?php

namespace UKFast\SDK\PHaaS\Entities;

class User
{
    public $id;
    public $firstName;
    public $lastName;
    public $email;
    public $position;
    public $createdAt;
    public $updatedAt;

    /**
     * User constructor.
     * @param $item
     */
    public function __construct($item)
    {
        $this->id = $item->id;
        $this->firstName = $item->first_name;
        $this->lastName = $item->last_name;
        $this->email = $item->email;
        $this->position = $item->position;
        $this->createdAt = $item->created_at;
        $this->updatedAt = $item->updated_at;
    }
}
