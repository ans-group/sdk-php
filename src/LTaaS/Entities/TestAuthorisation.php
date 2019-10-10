<?php

namespace UKFast\SDK\LTaaS\Entities;

class TestAuthorisation
{
    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $testId;

    /**
     * @var string
     */
    public $agreementVersion;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $position;

    /**
     * @var string
     */
    public $company;

    /**
     * @var string
     */
    public $createdAt;

    public function __construct($item = null)
    {
        if (is_null($item)) {
            return;
        }

        $this->id = $item->id;
        $this->testId = (isset($item->test_id)) ? $item->test_id : null;
        $this->agreementVersion = $item->agreement_version;
        $this->name = $item->name;
        $this->position = $item->position;
        $this->company = (isset($item->position)) ? $item->position : null;
        $this->createdAt = $item->created_at;
    }
}
