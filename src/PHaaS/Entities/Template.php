<?php

namespace UKFast\PHaaS\Entities;

class Template
{
    public $id;
    public $name;
    public $description;
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
        $this->createdAt = $item->created_at;
        $this->updatedAt = $item->updated_at;
    }
}
