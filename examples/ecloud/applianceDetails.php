<?php

// example of loading eCloud Appliance details
//
// php examples/ecloud/podApplianceList.php

require_once dirname(__FILE__) . '/../../vendor/autoload.php';

$ecloud = (new \UKFast\SDK\eCloud\Client)->auth(
    getenv('UKFAST_API_KEY')
);

if (empty($argv[1])) {
    echo 'missing appliance uuid'.PHP_EOL;
    exit;
}

$appliance = $ecloud->appliances()->getById($argv[1]);
print_r($appliance);
echo PHP_EOL;

$applianceVersion = $ecloud->appliances()->getVersion($appliance->id);
print_r($applianceVersion);
echo PHP_EOL;

$applianceParameters = $ecloud->appliances()->getParameters($appliance->id);
print_r($applianceParameters);
echo PHP_EOL;
