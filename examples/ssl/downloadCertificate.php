<?php

// example of downloading an SSL Certificate
//
// php examples/ssl/downloadCertificate.php 12345

require_once dirname(__FILE__) . '/../../vendor/autoload.php';

$ssl = (new \UKFast\SSL\Client)->auth(
    getenv('UKFAST_API_KEY')
);

$id = $argv[1];
$pemCertificate = $ssl->certificates()->getCertificatePEM($id);
print_r($pemCertificate->server);

/*
-----BEGIN CERTIFICATE-----
MIIG9jCCBd6gAwIBAgIQWkpUA0VCnB87XXoU19sWwzANBgkqhkiG9w0BAQsFADCB
kDELMAkGA1UEBhMCR0IxGzAZBgNVBAgTEkdyZWF0ZXIgTWFuY2hlc3RlcjEQMA4G

 ...

jXOkG5uHKrZp0JupQzz+kevoPDZszw9UNaOQmOjeT0b+cX3fMZaF/pEHnU8FRPxk
WYdp0UGurKampQ==
-----END CERTIFICATE-----
 */
