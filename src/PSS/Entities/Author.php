<?php

namespace UKFast\SDK\PSS\Entities;

class Author
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $type;

    public function __construct($item)
    {
        $this->id = $item->id;
        $this->name = $item->name;
        $this->type = $item->type;
    }

    /**
     * @return bool
     */
    public function isSupport()
    {
        return $this->type === 'Support';
    }

    /**
     * @return bool
     */
    public function isClient()
    {
        return $this->type === 'Client';
    }

    /**
     * @return bool
     */
    public function isAutomated()
    {
        return $this->type === 'Automated';
    }
}
