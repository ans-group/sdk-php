<?php

namespace UKFast\SDK\PHaaS\Entities;

class Domain
{
    public $id;
    public $domain;
    public $verificationEmail;
    public $verificationSent;
    public $verificationDate;
    public $status;
    public $createdAt;
    public $updatedAt;

    /**
     * Domain constructor.
     * @param $item
     */
    public function __construct($item)
    {
        $this->id = $item->id;
        $this->domain = $item->domain;
        $this->verificationEmail = $item->verification_email;
        $this->verificationSent = $item->verification_sent;
        $this->verificationDate = $item->verification_date;
        $this->status = $item->status;
        $this->createdAt = $item->created_at;
        $this->updatedAt = $item->updated_at;
    }
}
