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
    public $protocol;

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
    public $domainName;

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
        $this->protocol = $item->protocol;
        $this->path = $item->path;
        $this->numberUsers = $item->number_of_users;
        $this->duration = $item->duration;
        $this->scenarioName = $item->scenario_name;
        $this->recurringType = $item->recurring_type;
        $this->recurringValue = $item->recurring_value;
        $this->nextRun = $item->next_run;
        $this->domainName = $item->domain->name;
    }
}
