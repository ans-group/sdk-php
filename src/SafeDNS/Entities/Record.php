<?php

namespace UKFast\SDK\SafeDNS\Entities;

use UKFast\SDK\Entities\Entity;

class Record extends Entity
{
    /**
     * The ID of the record
     *
     * @var int
     */
    public $id;

    /**
     * The name of the zone the record belongs to
     *
     * @var string
     */
    public $zone;

    /**
     * The domain name the record describes
     *
     * @var string
     */
    public $name;

    /**
     * The type of DNS record
     *
     * @var string
     */
    public $type;

    /**
     * The content of the DNS record
     *
     * @var string
     */
    public $content;

    /**
     * The TTL (time to load) of the record
     *
     * @var int
     */
    public $ttl;

    /**
     * The priority of the record
     * @var string
     */
    public $priority;
}
