<?php

namespace UKFast\SDK\PSS\Entities;

class Reply
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var int
     */
    public $requestId;

    /**
     * @var \UKFast\SDK\Pss\Entities\Author
     */
    public $author;

    /**
     * @var string
     */
    public $description;

    /**
     * @var \DateTime
     */
    public $createdAt;

    /**
     * @var array
     */
    public $attachments = [];

    /**
     * @var bool
     */
    public $read;
}
