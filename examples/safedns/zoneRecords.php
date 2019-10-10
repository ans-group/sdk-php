<?php

// example of displaying records for a SafeDNS Zone
//
// php examples/safedns/zoneRecords.php ukfast.io

require_once dirname(__FILE__) . '/../../vendor/autoload.php';

$safedns = (new \UKFast\SDK\SafeDNS\Client)->auth(
    getenv('UKFAST_API_KEY')
);

$zoneName = $argv[1];
$zone = $safedns->zones()->getByName($zoneName);

foreach ($safedns->records()->getByZoneName($zone->name) as $record) {
    echo "# {$record->id} {$record->name} {$record->type} {$record->content} \n";
}

// # 123456 api.ukfast.io A 203.0.113.20
