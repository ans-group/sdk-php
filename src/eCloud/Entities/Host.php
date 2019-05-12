<?php

namespace UKFast\eCloud\Entities;

class Host
{
    public $id;
    public $name;

    public $cpu;
    public $ram;

    public $solutionId;
    public $podId;


    /**
     * Host constructor.
     * @param null $item
     */
    public function __construct($item = null)
    {
        if (empty($item)) {
            return;
        }

        $this->id = $item->id;
        $this->name = $item->name;

        $this->cpu = $item->cpu;
        $this->ram = $item->ram;

        $this->solutionId = $item->solution_id;
        $this->podId = $item->pod_id;
    }
}
