<?php

namespace UKFast\SDK\Domains\Entities;

class Whois
{
    public $name;
    public $status;

    public $createdAt;
    public $updatedAt;
    public $expiresAt;

    public $nameservers;
    public $registrar;


    /**
     * Whois constructor.
     * @param null $item
     */
    public function __construct($item = null)
    {
        if (empty($item)) {
            return;
        }

        $this->name = $item->name;
        $this->status = $item->status;

        $this->createdAt = $item->created_at;
        $this->updatedAt = $item->updated_at;
        $this->expiresAt = $item->expires_at;

        $this->nameservers = array_map(function ($item) {
            return new Nameserver($item);
        }, $item->nameservers);

        $this->registrar = new Registrar($item->registrar);
    }
}
