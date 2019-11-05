<?php

namespace UKFast\SDK\eCloud\Entities;

use UKFast\SDK\Entities\Entity;

class Iops extends Entity
{
    /**
     * @var string IOPS tier UUID
     */
    public $id;

    /**
     * @var string IOPS tier name
     */
    public $name;

    /**
     * @var int IOPS limit to apply to a datastore
     */
    public $limit;
}
