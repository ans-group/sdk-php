<?php

namespace UKFast\SDK\LTaaS\Entities;

class Test
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
    public $recurringType;

    /**
     * @var integer
     */
    public $recurringValue;

    /**
     * @var string
     */
    public $nextRun;

    /**
     * @var string
     */
    public $domainId;

    /**
     * @var string
     */
    public $domainName;

    /**
     * @var string
     */
    public $scenarioId;

    /**
     * @var boolean
     */
    public $runNow;

    /**
     * @var array
     */
    public $sectionUsers;

    /**
     * @var array
     */
    public $sectionTime;

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
        $this->name = $item->name;
        $this->path = $item->path;
        $this->numberUsers = $item->number_of_users;
        $this->duration = $item->duration;
        $this->recurringType = $item->recurring_type;
        $this->recurringValue = $item->recurring_value;
        $this->nextRun = $item->next_run;

        $this->scenarioName = (isset($item->scenario_name)) ? $item->scenario_name : null;
        $this->scenarioId = (isset($item->scenarioId)) ? $item->scenarioId : null;
        $this->runNow = (isset($item->runNow)) ? $item->runNow : null;
        $this->sectionUsers = (isset($item->sectionUsers)) ? $item->sectionUsers : null;
        $this->sectionTime = (isset($item->sectionTime)) ? $item->sectionTime : null;
        $this->thresholds = (isset($item->thresholds)) ? $item->thresholds : null;

        if (isset($item->domain)) {
            $this->domainId = $item->domain->id;
            $this->domainName = $item->domain->name;
        }
    }
}
