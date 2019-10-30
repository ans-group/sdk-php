<?php

namespace UKFast\SDK\SSL\Entities;

use UKFast\SDK\Entity;

/**
 * @property string                                       $name
 * @property \DateTime                                    $validFrom
 * @property \DateTime                                    $validTo
 * @property string                                       $issuer
 * @property string                                       $signatureAlgorithm
 * @property bool                                         $coversDomain
 * @property bool                                         $expiring
 * @property bool                                         $expired
 * @property bool                                         $secureSha
 * @property string                                       $ip
 * @property string                                       $hostname
 * @property string                                       $port
 * @property \DateTime                                    $currentTime
 * @property \DateTime                                    $serverTime
 * @property string                                       $serverSoftware
 * @property array                                        $domainsSecured
 * @property string                                       $serialNumber
 * @property bool                                         $multiDomain
 * @property bool                                         $wildcard
 * @property array                                        $vulnerabilities
 * @property string                                       $opensslVersion
 * @property array                                        $sslVersions
 * @property \UKFast\SDK\SSl\Entities\ReportCertificate[] $chain
 * @property bool                                         $chainIntact
 * @property array                                        $findings
 */
class Report extends Entity
{
    //
}
