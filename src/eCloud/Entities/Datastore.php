<?php

namespace UKFast\SDK\eCloud\Entities;

use UKFast\SDK\Entities\Entity;

class Datastore extends Entity
{
    public $id;
    public $name;
    public $status;

    public $capacity;
    public $allocated;
    public $available;

    public $solutionId;
    public $siteId;
}
