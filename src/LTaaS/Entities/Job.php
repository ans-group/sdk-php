<?php

namespace UKFast\SDK\LTaaS\Entities;

class Job
{
    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $testId;

    /**
     * @var string
     */
    public $domainId;

    /**
     * string
     */
    public $crdName;

    /**
     * @var boolean
     */
    public $configSubmitted;

    /**
     * @var boolean
     */
    public $crdSubmitted;

    /**
     * @var string
     */
    public $scheduledTimestamp;

    /**
     * @var string
     */
    public $jobStartTimestamp;

    /**
     * @var string
     */
    public $jobEndTimestamp;

    /**
     * @var string
     */
    public $status;

    /**
     * @var boolean
     */
    public $runNow;

    /**
     * @var string
     */
    public $failType;

    /**
     * @var string
     */
    public $created_at;

    /**
     * @var string
     */
    public $updated_at;

    /**
     * Test constructor.
     * @param null $item
     */
    public function __construct($item = null)
    {
        if (is_null($item)) {
            return;
        }

        $this->id = $item->id;
        $this->testId = $item->test_id;
        $this->domainId = $item->domain_id;
        $this->crdName = $item->crd_name;
        $this->configSubmitted = $item->config_submitted_successfully;
        $this->crdSubmitted = $item->crd_submitted_successfully;
        $this->scheduledTimestamp = $item->scheduled_timestamp;
        $this->runNow = (isset($item->run_now)) ? $item->run_now : null;
        $this->jobStartTimestamp = $item->job_start_timestamp;
        $this->jobEndTimestamp = $item->job_end_timestamp;
        $this->status = $item->status;
        $this->failType = $item->fail_type;
        $this->createdAt = $item->created_at;
        $this->updatedAt = $item->updated_at;
    }
}
