<?php

// example of listing safedns Zones
//
// php examples/safedns/zoneList.php

require_once dirname(__FILE__) . '/../../vendor/autoload.php';

$safedns = (new \UKFast\SDK\SafeDNS\Client)->auth(
    getenv('UKFAST_API_KEY')
);

$zones = $safedns->zones()->getAll();

foreach ($zones as $zone) {
    echo "# {$zone->name} - {$zone->description}".
         "\n";
}

// # ukfast.io - UKFast Developer API
