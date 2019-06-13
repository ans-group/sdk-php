<?php

namespace UKFast\PHaaS\Entities;

class Campaign
{
    public $id;
    public $name;
    public $startDateTime;
    public $endDateTime;
    public $emailTemplateId;
    public $status;
    public $results;
    public $timeline;
    public $createdAt;
    public $updatedAt;


    /**
     * Domain constructor.
     * @param $item
     */
    public function __construct($item)
    {
        $this->id = $item->id;
        $this->name = $item->name;
        $this->startDateTime = $item->start_date_time;
        $this->endDateTime = $item->end_date_time;
        $this->emailTemplateId = $item->email_template_id;
        $this->status = $item->status;
        $this->results = $item->results;
        $this->timeline = $item->timeline;
        $this->createdAt = $item->created_at;
        $this->updatedAt = $item->updated_at;
    }
}
