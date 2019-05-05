<?php

// example of querying your Account Details
//
// php examples/account/details.php

require_once dirname(__FILE__) . '/../../vendor/autoload.php';

$account = (new \UKFast\Account\Client)->auth(
    getenv('UKFAST_API_KEY')
);

$details = $account->getDetails();
print_r($details);
