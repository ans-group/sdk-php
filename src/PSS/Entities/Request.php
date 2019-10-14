<?php

namespace UKFast\SDK\PSS\Entities;

class Request
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var \UKFast\SDK\Pss\Entities\Author
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
    public $secure = true;

    /**
     * @var \Datetime
     */
    public $createdAt;

    /**
     * @var string
     */
    public $priority = 'Normal';

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
    public $requestSms = false;

    /**
     * @var string
     */
    public $customerReference;

    /**
     * @var \UKFast\SDK\Pss\Entities\Author
     */
    public $product;

    /**
     * @var \DateTime
     */
    public $lastRepliedAt;

    /**
     * @var string
     */
    public $systemReference;

    /**
     * @var string
     */
    public $details;

    /**
     * @var array
     */
    public $cc = [];

    /**
     * @var integer
     */
    public $unreadReplies;

    public function isCompleted()
    {
        return in_array($this->status, ['Completed', 'Replied and Completed']);
    }

    public function isArchived()
    {
        return $this->archived;
    }
}
