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
    public $template;
    public $createdAt;
    public $updatedAt;


    /**
     * Campaign constructor.
     * @param $item
     */
    public function __construct($item)
    {
        $this->id = $item->id;
        $this->name = $item->name;
        $this->startDateTime = $item->start_date_time;
        $this->endDateTime = $item->end_date_time;
        $this->emailTemplateId = $item->email_template_id;
        $this->template = $item->template;
        $this->status = $item->status;
        $this->createdAt = $item->created_at;
        $this->updatedAt = $item->updated_at;
    }
}
