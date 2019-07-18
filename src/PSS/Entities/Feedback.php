<?php

namespace UKFast\SDK\PSS\Entities;

class Feedback
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var int
     */
    public $contactId;

    /**
     * @var int
     */
    public $speedResolved;

    /**
     * @var int
     */
    public $quality;

    /**
     * @var int
     */
    public $score;

    /**
     * @var int
     */
    public $npsScore;

    /**
     * @var int
     */
    public $thirdPartyConsent;

    /**
     * @var string
     */
    public $comment;
}
