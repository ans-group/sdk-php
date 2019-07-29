<?php

namespace UKFast\SDK\LTaaS\Entities;

class JobResults
{
    /**
     * @var array
     */
    public $virtualUsers;

    /**
     * @var array
     */
    public $successfulRequests;

    /**
     * @var array
     */
    public $failedRequests;

    /**
     * @var array
     */
    public $latency;
    /**
     * Job constructor.
     * @param null $item
     */
    public function __construct($item = null)
    {
        $this->virtualUsers = $item->virtual_users;
        $this->successfulRequests = $item->successful_requests;
        $this->failedRequests = $item->failed_requests;
        $this->latency = $item->latency;
    }
}
