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

    /**
     * @var string
     */
    public $verificationMethod;

    /**
     * @var string
     */
    public $verificationString;

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
        $this->verificationMethod = (isset($item->verification_method)) ? $item->verification_method : null;
        $this->verificationString = (isset($item->verify_hash)) ? $item->verify_hash : null;
        $this->successfulTests = (isset($item->successful_jobs_count)) ? $item->successful_jobs_count : null;
        $this->failedTests = (isset($item->failed_jobs_count)) ? $item->failed_jobs_count : null;
        $this->lastTestRan = (isset($item->last_job_date)) ? $item->last_job_date : null;
    }
}
