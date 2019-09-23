<?php

namespace UKFast\SDK\PSS\Entities;

use UKFast\SDK\Entity;

/**
 * @property int $id
 * @property \UKFast\SDK\PSS\Entities\Author $author
 * @property string $type
 * @property string $subject
 * @property bool $secure
 * @property \DateTime $createdAt
 * @property string $priority
 * @property bool $archived
 * @property string $status
 * @property bool $requestSms
 * @property string $customerReference
 * @property \UKFast\SDK\PSS\Entities\Product $product
 * @property \DateTime $lastRepliedAt
 * @property string $systemReference
 * @property string $details
 * @property array $cc
 * @property integer $unreadReplies
 */
class Request extends Entity
{
    protected $readOnly = [
        'id', 'createdAt', 'unreadReplies'
    ];

    public function isCompleted()
    {
        return in_array($this->status, ['Completed', 'Replied and Completed']);
    }

    public function isArchived()
    {
        return $this->archived;
    }
}
