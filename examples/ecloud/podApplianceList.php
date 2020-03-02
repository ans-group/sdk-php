<?php

// example of listing eCloud Appliances
//
// php examples/ecloud/podApplianceList.php

require_once dirname(__FILE__) . '/../../vendor/autoload.php';

$ecloud = (new \UKFast\SDK\eCloud\Client)->auth(
    getenv('UKFAST_API_KEY')
);

$appliances = $ecloud->pods()->getAppliances(
    14
)->getItems();

foreach ($appliances as $appliance) {
    echo "// {$appliance->id} \t {$appliance->name} \n";
}

// 6e12d729-ca82-49f9-89d2-eec2360c482a 	 CentOS 7
// b1f096cb-8bf1-4665-956e-20c1a28db556 	 Docker
// 80426b08-fc0f-4e5d-9e3c-43ce517b25d8 	 Ghost
