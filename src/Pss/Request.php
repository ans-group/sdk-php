<?php

namespace UKFast\Pss;

class Request
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var \UKFast\Pss\Author
     */
    public $author;

    /**
     * @var string
     */
    public $type;

    /**
     * @var string
     */
    public $subject;

    /**
     * @var bool
     */
    public $secure;

    /**
     * @var \Datetime
     */
    public $createdAt;

    /**
     * @var string
     */
    public $priority;

    /**
     * @var bool
     */
    public $archived;

    /**
     * @var string
     */
    public $status;

    /**
     * @var bool
     */
    public $requestSms;

    /**
     * @var string
     */
    public $customerReference;
}
