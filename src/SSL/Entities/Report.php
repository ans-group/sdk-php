<?php

namespace UKFast\SDK\SSL\Entities;

use UKFast\SDK\Entities\Entity;

class Report extends Entity
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $validFrom;

    /**
     * @var string
     */
    public $validTo;

    /**
     * @var string
     */
    public $issuer;

    /**
     * @var string
     */
    public $signatureAlgorithm;

    /**
     * @var string
     */
    public $domainCovered;

    /**
     * @var string
     */
    public $certExpiresInLessThan30Days;

    /**
     * @var string
     */
    public $certExpired;

    /**
     * @var string
     */
    public $secureSha;

    /**
     * @var string
     */
    public $ip;

    /**
     * @var string
     */
    public $hostname;

    /**
     * @var string
     */
    public $port;

    /**
     * @var string
     */
    public $currentTime;

    /**
     * @var string
     */
    public $serverTime;

    /**
     * @var string
     */
    public $serverSoftware;

    /**
     * @var string
     */
    public $domainsSecured;

    /**
     * @var string
     */
    public $serialNumber;

    /**
     * @var string
     */
    public $multiDomain;

    /**
     * @var string
     */
    public $wildcard;

    /**
     * @var array
     */
    public $vulnerabilities = [];

    /**
     * @var string
     */
    public $opensslVersion;

    /**
     * @var array
     */
    public $sslVersions = [];

    /**
     * @var array
     */
    public $chain = [];

    /**
     * @var string
     */
    public $status;

    /**
     * @var string
     */
    public $error;
}
