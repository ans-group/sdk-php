<?php

// example of displaying details of a SafeDNS Zone
//
// php examples/safedns/zoneDetail.php ukfast.io

require_once dirname(__FILE__) . '/../../vendor/autoload.php';

$safedns = (new \UKFast\SDK\SafeDNS\Client)->auth(
    getenv('UKFAST_API_KEY')
);

$zoneName = $argv[1];
$zone = $safedns->zones()->getByName($zoneName);

print_r($zone);
