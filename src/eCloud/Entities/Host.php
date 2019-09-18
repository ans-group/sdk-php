<?php

namespace UKFast\SDK\eCloud\Entities;

use UKFast\SDK\Entities\Entity;

class Host extends Entity
{
    /**
     * @var integer Host Identifier
     */
    public $id;

    /**
     * @var string Host name
     */
    public $name;

    /**
     * @var object CPU specification
     */
    public $cpu;

    /**
     * @var object RAM specification
     */
    public $ram;

    /**
     * @var integer Solution ID
     */
    public $solutionId;

    /**
     * @var integer Pod ID
     */
    public $podId;
}
