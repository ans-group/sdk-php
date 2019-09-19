<?php

namespace UKFast\SDK\eCloud\Entities;

class Template
{
    public $name;

    public $cpu;
    public $ram;

    public $hdd;
    public $disks;
    public $encrypted;

    public $platform;


    /**
     * Template constructor.
     * @param null $item
     */
    public function __construct($item = null)
    {
        if (empty($item)) {
            return;
        }

        $this->name = $item->name;

        $this->cpu = $item->cpu;
        $this->ram = $item->ram;

        $this->hdd = $item->hdd;
        $this->disks = array_map(function ($item) {
            return new Hdd($item);
        }, $item->hdd_disks);
        $this->encrypted = $item->encrypted;

        $this->platform = $item->platform;
    }
}
