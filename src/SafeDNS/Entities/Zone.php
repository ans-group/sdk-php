<?php

namespace UKFast\SDK\SafeDNS\Entities;

use UKFast\SDK\Entity;

class Zone extends Entity
{
    /**
     * The domain name of the zone
     *
     * @var string
     */
    public $name;

    /**
     * A text description of the zone
     *
     * @var string
     */
    public $description;
}
