<?php

namespace UKFast\SDK\PHaaS\Entities;

class Group
{
    public $id;
    public $accountId;
    public $name;
    public $createdAt;
    public $updatedAt;
    public $userCount;
    public $users;

    /**
     * Group constructor.
     * @param $item
     */
    public function __construct($item)
    {
        $this->id = $item->id;
        $this->accountId = $item->account_id;
        $this->name = $item->name;
        $this->userCount = $item->user_count;
        $this->createdAt = $item->created_at;
        $this->users = isset($item->users) ? $item->users : [];
    }
}
