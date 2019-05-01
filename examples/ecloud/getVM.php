<?php

// example of listing eCloud Virtual Machines
//
// php examples/ecloud/getVM.php 12345

require_once dirname(__FILE__) . '/../../vendor/autoload.php';

$ecloud = (new \UKFast\eCloud\Client)->auth(
    getenv('UKFAST_API_KEY')
);

$id = $argv[1];
$virtualMachine = $ecloud->getVirtualMachine($id);

print_r($virtualMachine);
