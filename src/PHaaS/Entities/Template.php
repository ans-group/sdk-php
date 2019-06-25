<?php

namespace UKFast\PHaaS\Entities;

class Template
{
    public $id;
    public $name;
    public $description;
    public $emailId;
    public $landingId;
    public $createdAt;
    public $updatedAt;


    /**
     * Template constructor.
     * @param $item
     */
    public function __construct($item)
    {
        $this->id = $item->id;
        $this->name = $item->name;
        $this->description = $item->description;
        $this->emailId = $item->email_id;
        $this->landingId = $item->landing_id;
        $this->createdAt = $item->created_at;
        $this->updatedAt = $item->updated_at;
    }
}
