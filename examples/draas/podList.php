<?php

// example of listing DRaaS Pods
//
// php examples/draas/podList.php

require_once dirname(__FILE__) . '/../../vendor/autoload.php';

$draas = (new \UKFast\SDK\DRaaS\Client)->auth(
    getenv('UKFAST_API_KEY')
);

foreach ($draas->pods()->getPage()->getItems() as $pod) {
    echo "# {$pod->id} - {$pod->name}".
        "\n";
}

# 15c5ac2c-60be-458f-868b-27ffd7236579 - London Central
# 542a807d-77f3-46d4-a4a1-2f53a82ecd48 - Manchester North
