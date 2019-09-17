<?php

namespace UKFast\SDK\SSL\Entities;

class CheckedCertificate
{
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
     * @var string
     */
    public $heartbleedVulnerable;

    /**
     * @var string
     */
    public $opensslVersion;

    /**
     * @var array
     */
    public $sslVersions = [];

    /**
     * @var string
     */
    public $status;

    /**
     * @var string
     */
    public $error;
}
