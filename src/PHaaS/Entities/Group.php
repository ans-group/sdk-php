<?php

namespace UKFast\PHaaS\Entities;

class Group
{
    public $id;
    public $accountId;
    public $name;
    public $createdAt;
    public $updatedAt;

    /**
     * Group constructor.
     * @param $item
     */
    public function __construct($item)
    {
        $this->id = $item->id;
        $this->accountId = $item->account_id;
        $this->name = $item->name;
        $this->createdAt = $item->created_at;
    }
}
