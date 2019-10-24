<?php

namespace UKFast\SDK\SSL\Entities;

use UKFast\SDK\Entity;

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
     * @var bool
     */
    public $coversDomain;

    /**
     * @var bool
     */
    public $expiring;

    /**
     * @var bool
     */
    public $expired;

    /**
     * @var bool
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
     * @var bool
     */
    public $chainIntact;

    /**
     * @var array
     */
    public $findings;
}
