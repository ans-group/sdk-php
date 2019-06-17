<?php

namespace UKFast\eCloud\Entities;

class Pod
{
    public $id;
    public $name;
    public $services;

    /**
     * Pod constructor.
     * @param null $item
     */
    public function __construct($item = null)
    {
        if (empty($item)) {
            return;
        }

        $this->id = $item->id;
        $this->name = $item->name;

        $this->services = (object) [
            'public' => $item->services->public,
            'burst' => $item->services->burst,
            'appliances' => $item->services->appliances,
        ];
    }
}
