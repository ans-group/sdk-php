<?php

// example of running a WHOIS search against a Domain/IP
//
// php examples/ssl/whoisLookup.php ukfast.net

require_once dirname(__FILE__) . '/../../vendor/autoload.php';

$domains = (new \UKFast\Domains\Client)->auth(
    getenv('UKFAST_API_KEY')
);

$target = $argv[1];
$record = $domains->whois()->getRecord($target);
print_r($record);

/*
UKFast\Domains\Whois Object
(
    [name] => ukfast.net
    [status] => Array
        (
            [0] => clientTransferProhibited https://icann.org/epp#clientTransferProhibited
        )

    [createdAt] => 1999-09-27T14:42:25+00:00
    [updatedAt] => 2018-10-02T15:24:29+00:00
    [expiresAt] => 2019-09-27T14:42:21+00:00
    [nameservers] => Array
        (
            [0] => UKFast\Domains\Nameserver Object
                (
                    [host] => ns0.ukfast.net
                    [ip] =>
                )

            [1] => UKFast\Domains\Nameserver Object
                (
                    [host] => ns1.ukfast.net
                    [ip] =>
                )

        )

    [registrar] => UKFast\Domains\Registrar Object
        (
            [name] => eNom, LLC
            [url] => http://www.enom.com
            [tag] =>
            [ianaId] => 48
        )
)
 */
