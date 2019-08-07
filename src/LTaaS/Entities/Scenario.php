<?php

namespace UKFast\SDK\LTaaS\Entities;

class Scenario
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
     * @var boolean
     */
    public $availableTrial;

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
        $this->name = $item->name;
        $this->availableTrial = $item->available_trial;
        $this->formula = $item->formula;
        $this->description = $item->description;
    }
}
