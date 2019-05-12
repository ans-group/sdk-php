<?php

namespace UKFast\eCloud\Entities;

class VirtualMachine
{
    public $id;
    public $name;
    public $status;

    public $computerName;
    public $hostname;

    public $cpu;
    public $ram;
    public $hdd;
    public $disks;

    public $ip_addresses;

    public $template;
    public $platform;

    public $backup;
    public $support;

    public $environment;
    public $solutionId;

    public $power;
    public $tools;


    /**
     * VirtualMachine constructor.
     * @param null $item
     */
    public function __construct($item = null)
    {
        if (empty($item)) {
            return;
        }


        $this->id = $item->id;
        $this->name = $item->name;

        $this->computerName = $item->computername;
        $this->hostname = $item->hostname;

        $this->cpu = $item->cpu;
        $this->ram = $item->ram;
        $this->hdd = $item->hdd;

        if (isset($item->hdd_disks)) {
            $this->disks = array_map(function ($item) {
                return new Hdd($item);
            }, $item->hdd_disks);
        }

        $this->ip_addresses = (object) [
            'internal' => $item->ip_internal,
            'external' => $item->ip_external,
        ];

        $this->template = $item->template;
        $this->platform = $item->platform;

        $this->backup = $item->backup;
        $this->support = $item->support;

        $this->environment = $item->environment;
        $this->solutionId = $item->solution_id;

        $this->status = $item->status;

        if (isset($item->power_status)) {
            $this->power = $item->power_status;
        }

        if (isset($item->power_status)) {
            $this->tools = $item->tools_status;
        }
    }
}
