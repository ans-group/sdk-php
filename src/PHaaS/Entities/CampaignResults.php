<?php

namespace UKFast\SDK\PHaaS\Entities;

class CampaignResults
{
    public $emailSent;
    public $emailOpened;
    public $clickedLink;
    public $submittedData;

    /**
     * CampaignResults constructor.
     * @param $item
     */
    public function __construct($item)
    {
        $this->emailSent = $item->email_sent;
        $this->emailOpened = $item->email_opened;
        $this->clickedLink = $item->clicked_link;
        $this->submittedData = $item->submitted_data;
    }
}
