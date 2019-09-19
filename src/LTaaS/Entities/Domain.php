<?php

namespace UKFast\SDK\LTaaS\Entities;

class Domain
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
    public $verificationMethod;

    /**
     * @var string
     */
    public $verificationString;

    /**
     * @var string
     */
    public $status;

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
        $this->name = (isset($item->name)) ? $item->name : null;
        $this->verificationMethod = (isset($item->verification_method)) ? $item->verification_method : null;
        $this->verificationString = $item->verify_hash;
        $this->status = (isset($item->status)) ? $item->status : null;
        $this->createdAt = (isset($item->created_at)) ? $item->created_at : null;
        $this->createdAt = (isset($item->updated_at)) ? $item->updated_at : null;
    }
}
