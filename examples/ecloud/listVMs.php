<?php

// example of listing eCloud Virtual Machines
//
// php examples/ecloud/listVMs.php

require_once dirname(__FILE__) . '/../../vendor/autoload.php';

$ecloud = (new \UKFast\eCloud\Client)->auth(
    getenv('UKFAST_API_KEY')
);

$page = $ecloud->virtualMachines()->getAll();

foreach ($page->getItems() as $virtualMachine) {
    echo "# {$virtualMachine->id} - {$virtualMachine->hostname}\n";
}

// # 12345 - 192.0.2.1.srvlist.ukfast.net
