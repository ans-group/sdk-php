<?php

// example of querying your Account Company Details
//
// php examples/account/companyDetails.php

require_once dirname(__FILE__) . '/../../vendor/autoload.php';

$account = (new \UKFast\Account\Client)->auth(
    getenv('UKFAST_API_KEY')
);

$details = $account->company()->getDetails();
print_r($details);

/*

UKFast\Account\Entities\Company Object
(
    [companyRegistrationNumber] => 038 45616
    [vatIdentificationNumber] => 741 1237 68
    [primaryContactId] => 12345
)

*/