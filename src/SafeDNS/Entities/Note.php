<?php

namespace UKFast\SDK\SafeDNS\Entities;

use UKFast\SDK\Entities\Entity;

class Note extends Entity
{
    /**
     * The ID of the note
     *
     * @var integer
     */
    public $id;

    /**
     * The ID of the contact who has created the note
     *
     * @link https://api.ukfast.io/account/v1/contacts
     * @var integer
     */
    public $contactId;

    /**
     * The note taken
     *
     * @var string
     */
    public $note;

    /**
     * @var \DateTime
     */
    public $createdAt;

    /**
     * The IP address from which the note was created
     *
     * @var string
     */
    public $ipAddress;
}
