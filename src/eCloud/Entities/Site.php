<?php

namespace UKFast\SDK\eCloud\Entities;

class Site
{
    public $id;
    public $state;

    public $solutionId;
    public $podId;

    /**
     * Site constructor.
     * @param null $item
     */
    public function __construct($item = null)
    {
        if (empty($item)) {
            return;
        }

        $this->id = $item->id;
        $this->state = $item->state;

        $this->solutionId = $item->solution_id;
        $this->podId = $item->pod_id;
    }
}
