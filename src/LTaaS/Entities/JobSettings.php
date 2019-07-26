<?php

namespace UKFast\SDK\LTaaS\Entities;

class JobSettings
{
    /**
     * @var string
     */
    public $date;

    /**
     * @var string
     */
    public $type;

    /**
     * @var string
     */
    public $duration;

    /**
     * @var integer
     */
    public $numberOfUsers;

    /**
     * Job constructor.
     * @param null $item
     */
    public function __construct($item = null)
    {
        $this->date = $item->date;
        $this->type = $item->type;
        $this->duration = $item->duration;
        $this->numberOfUsers = $item->max_users;
    }
}
