<?php

namespace UKFast\SDK\Domains\Entities;

class Domain
{
    public $name;
    public $status;

    public $clientId;
    public $clientName;
    public $registrar;

    public $registeredAt;
    public $createdAt;
    public $updatedAt;
    public $renewalAt;
    public $expiresAt;

    public $autoRenew;
    public $whoisPrivacy;
    public $transferLocked;


    /**
     * Domain constructor, from a registrar v2 domain. Every part is
     * optional, as a write response only carries some of a domain.
     * @param null $item
     */
    public function __construct($item = null)
    {
        if (empty($item)) {
            return;
        }

        if (isset($item->name)) {
            $this->name = $item->name;
        }

        if (isset($item->registration)) {
            $this->status = isset($item->registration->status) ? $item->registration->status : null;
            $this->registeredAt = isset($item->registration->date) ? $item->registration->date : null;
        }

        if (isset($item->client)) {
            $this->clientId = isset($item->client->id) ? $item->client->id : null;
            $this->clientName = isset($item->client->name) ? $item->client->name : null;
        }

        if (isset($item->registrar)) {
            $this->registrar = isset($item->registrar->name) ? $item->registrar->name : null;
        }

        if (isset($item->renewal)) {
            $this->renewalAt = isset($item->renewal->date) ? $item->renewal->date : null;
            $this->autoRenew = isset($item->renewal->auto) ? $item->renewal->auto : null;
        }

        if (isset($item->expiry)) {
            $this->expiresAt = isset($item->expiry->date) ? $item->expiry->date : null;
        }

        if (isset($item->registrant)) {
            $this->whoisPrivacy = isset($item->registrant->privacy) ? $item->registrant->privacy : null;
        }

        if (isset($item->transfer)) {
            $this->transferLocked = isset($item->transfer->locked) ? $item->transfer->locked : null;
        }

        if (isset($item->created_at)) {
            $this->createdAt = $item->created_at;
        }

        if (isset($item->updated_at)) {
            $this->updatedAt = $item->updated_at;
        }
    }
}
