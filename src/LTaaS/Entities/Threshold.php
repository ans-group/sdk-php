<?php

namespace UKFast\SDK\LTaaS\Entities;

class Threshold
{
    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $description;

    /**
     * @var string
     */
    public $query;

    /**
     * @var string
     */
    public $createdAt;

    /**
     * @var string
     */
    public $updatedAt;

    public function __construct($item = null)
    {
        if (is_null($item)) {
            return;
        }

        $this->id = $item->id;
        $this->name = $item->name;
        $this->description = $item->description;
        $this->query = $item->query;
        $this->createdAt = $item->created_at;
        $this->updatedAt = $item->updated_at;
    }
}
