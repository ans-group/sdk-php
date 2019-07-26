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
     * string
     */
    public $crdName;

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
    public $path;

    /**
     * @var integer
     */
    public $numberUsers;

    /**
     * @var string
     */
    public $duration;

    /**
     * @var string
     */
    public $scenarioName;

    /**
     * @var string
     */
    public $domainName;

    /**
     * @var string
     */
    public $testName;

    /**
     * @var array
     */
    public $thresholds;

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
        $this->testId = isset($item->test_id) ? $item->test_id : null;
        $this->scheduledTimestamp = $item->scheduled_timestamp;
        $this->runNow = (isset($item->run_now)) ? $item->run_now : null;
        $this->crdName = (isset($item->crd_name)) ? $item->crd_name : null;
        $this->jobStartTimestamp = (isset($item->job_start_timestamp)) ? $item->job_start_timestamp : null;
        $this->jobEndTimestamp = (isset($item->job_end_timestamp)) ? $item->job_end_timestamp : null;
        $this->status = (isset($item->status)) ? $item->status : null;

        if (isset($item->test)) {
            $this->path = $item->test->path;
            $this->scenarioName = $item->test->scenario_name;
            $this->numberUsers = $item->test->number_of_users;
            $this->duration = $item->test->duration;
            $this->testName = $item->test->name;
            $this->domainName = $item->test->domain->name;
        }

        if (isset($item->thresholds)) {
            $this->thresholds = $item->thresholds;
        }
    }
}
