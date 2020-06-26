<?php

// example of creating an eCloud Public Appliance
//
// php examples/ecloud/vmCreateAppliance.php

require_once dirname(__FILE__) . '/../../vendor/autoload.php';

$ecloud = (new \UKFast\SDK\eCloud\Client)->auth(
    getenv('UKFAST_API_KEY')
);

$virtualMachine = new \UKFast\SDK\eCloud\Entities\VirtualMachine;
$virtualMachine->environment = 'Public';
$virtualMachine->podId = 14;

$virtualMachine->applianceId = '80426b08-fc0f-4e5d-9e3c-43ce517b25d8';
$virtualMachine->applianceParameters = [
    'ghost_url' => 'ghost.ukfast.dev',
];

$virtualMachine->name = 'API example - ' . date('Ymd.His');
$virtualMachine->cpu = 1;
$virtualMachine->ram = 1;
$virtualMachine->hdd = 20;

echo PHP_EOL;

try {
    $virtualMachine = $ecloud->virtualMachines()->create($virtualMachine);
} catch (Exception $exception) {
    echo 'Exception: ' . $exception->getMessage();
    echo PHP_EOL.PHP_EOL;
}

print_r($virtualMachine);

echo PHP_EOL;
