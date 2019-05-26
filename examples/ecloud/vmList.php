<?php

// example of listing eCloud Virtual Machines
//
// php examples/ecloud/vmList.php

require_once dirname(__FILE__) . '/../../vendor/autoload.php';

$ecloud = (new \UKFast\eCloud\Client)->auth(
    getenv('UKFAST_API_KEY')
);

$page = $ecloud->virtualMachines()->getAll(2);

foreach ($page->getItems() as $virtualMachine) {
    echo "# {$virtualMachine->id} - {$virtualMachine->hostname}".
        "\t {$virtualMachine->status} \t {$virtualMachine->name}" .
        "\n";
}

// # 12345 - 192.0.2.1.srvlist.ukfast.net
