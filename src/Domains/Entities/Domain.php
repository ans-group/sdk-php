<?php

namespace UKFast\SDK\Domains\Entities;

class Domain
{
    public $name;
    public $status;

    public $registrar;

    public $registeredAt;
    public $updatedAt;
    public $renewalAt;

    public $autoRenew;
    public $whoisPrivacy;


    /**
     * Domain constructor.
     * @param null $item
     */
    public function __construct($item = null)
    {
        if (empty($item)) {
            return;
        }

        $this->name = $item->name;
        $this->status = $item->status;

        $this->registrar = $item->registrar;

        $this->registeredAt = $item->registered_at;
        $this->updatedAt = $item->updated_at;
        $this->renewalAt = $item->renewal_at;

        $this->autoRenew = $item->auto_renew;
        $this->whoisPrivacy = $item->whois_privacy;
    }
}
