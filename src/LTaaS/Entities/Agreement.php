<?php

namespace UKFast\SDK\LTaaS\Entities;

class Agreement
{
    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $agreement;

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
        $this->agreement = $item->agreement;
        $this->createdAt = $item->created_at;
        $this->updatedAt = $item->updated_at;
    }
}
