<?php

namespace UKFast\eCloud\Entities;

class Datastore
{
    public $id;
    public $name;
    public $status;

    public $capacity;
    public $allocated;
    public $available;

    public $solutionId;
    public $siteId;

    /**
     * Datastore constructor.
     * @param null $item
     */
    public function __construct($item = null)
    {
        if (empty($item)) {
            return;
        }

        $this->id = $item->id;
        $this->name = $item->name;
        $this->status = $item->status;

        $this->capacity = $item->capacity;
        $this->allocated = $item->allocated;
        $this->available = $item->available;

        $this->solutionId = $item->solution_id;
        $this->siteId = $item->site_id;
    }
}
