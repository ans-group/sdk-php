<?php

namespace UKFast\eCloud;

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
}
