<?php

namespace UKFast\SDK\LTaaS\Entities;

class Scenario
{
    /**
     * @var string
     */
    public $id;

    /**
     * @var boolean
     */
    public $available_trial;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $formula;

    /**
     * @var string
     */
    public $description;

    public function __construct($item = null)
    {
        if (is_null($item)) {
            return;
        }

        $this->id = $item->id;
        $this->available_trial = $item->available_trial;
        $this->name = $item->name;
        $this->formula = $item->formula;
        $this->description = $item->description;
    }
}
