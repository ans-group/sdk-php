<?php

namespace UKFast\SDK\SSL\Entities;

use UKFast\SDK\Entities\Entity;

class ReportCertificate extends Entity
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
    public $serialNumber;

    /**
     * @var string
     */
    public $signatureAlgorithm;
}
