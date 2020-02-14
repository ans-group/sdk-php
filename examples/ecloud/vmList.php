<?php

// example of listing eCloud Virtual Machines
//
// php examples/ecloud/vmList.php

require_once dirname(__FILE__) . '/../../vendor/autoload.php';

$ecloud = (new \UKFast\SDK\eCloud\Client)->auth(
    getenv('UKFAST_API_KEY')
);

$virtualMachines = $ecloud->virtualMachines()->getAll();

foreach ($virtualMachines as $virtualMachine) {
    echo "# {$virtualMachine->id} - {$virtualMachine->hostname}".
        "\t {$virtualMachine->status} \t {$virtualMachine->name}" .
        "\t {$virtualMachine->ipAddresses->internal} \t {$virtualMachine->ipAddresses->external}" .
        "\n";
}

// # 12345 - 192.0.2.1.srvlist.ukfast.net	 Complete 	 LIVE web server 	 192.0.2.12 	 203.0.113.20
