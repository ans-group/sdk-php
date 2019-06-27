<?php

// example of querying account contacts per page
//
// php examples/account/contactPage.php 1

require_once dirname(__FILE__) . '/../../vendor/autoload.php';

$account = (new \UKFast\Account\Client)->auth(
    getenv('UKFAST_API_KEY')
);

$pageNumber = !empty($argv[1]) ? $argv[1] : 1;

$contactsPage = $account->contacts()->getPage($pageNumber);

echo "Showing page {$contactsPage->pageNumber()} of {$contactsPage->totalPages()}" . PHP_EOL;

foreach ($contactsPage->getItems() as $contact) {
    echo "# {$contact->id} - {$contact->fullName}".
        "\n";
}

/*

Showing page 1 of 1
# 12345 - Charles Babbage
# 54321 - Terry Pratchett

*/
