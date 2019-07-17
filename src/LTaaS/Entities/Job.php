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
    public $status;

    /**
     * @var string
     */
    public $jobStart;

    /**
     * @var
     */
    public $testName;

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
        $this->status = $item->status;
        $this->jobStart = $item->job_start_timestamp;
        $this->path = $item->test->path;
        $this->scenarioName = $item->test->scenario_name;
        $this->numberUsers = $item->test->number_of_users;
        $this->duration = $item->test->duration;
        $this->testName = $item->test->name;
        $this->domainName = $item->test->domain->name;
    }
}
