<?php

// example of loading a DRaaS Pod
//
// php examples/draas/podById.php aaaa-bbbb-cccc-dddd

require_once dirname(__FILE__) . '/../../vendor/autoload.php';

$draas = (new \UKFast\SDK\DRaaS\Client)->auth(
    getenv('UKFAST_API_KEY')
);

$pod = $draas->pods()->getById($argv[1]);
print_r($pod);
