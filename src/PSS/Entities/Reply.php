<?php

namespace UKFast\SDK\PSS\Entities;

class Reply
{
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
}
