<?php

namespace UKFast\SDK\LTaaS\Entities;

class Domain
{
    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $status;

    /**
     * @var integer
     */
    public $successfulTests;

    /**
     * @var integer
     */
    public $failedTests;

    /**
     * @var string
     */
    public $lastTestRan;

    public function __construct($item = null)
    {
        if (is_null($item)) {
            return;
        }

        $this->id = $item->id;
        $this->name = $item->name;
        $this->status = $item->status;
        $this->successfulTests = $item->successful_jobs_count;
        $this->failedTests = $item->failed_jobs_count;
        $this->lastTestRan = $item->last_job_date;
    }
}
