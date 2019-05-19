<?php

namespace UKFast\SSL\Entities;

class CertificatePEM
{
    public $server;
    public $intermediate;

    /**
     * CertificatePEM constructor.
     * @param null $item
     */
    public function __construct($item = null)
    {
        if (empty($item)) {
            return;
        }

        $this->server = $item->server;
        $this->intermediate = $item->intermediate;
    }
}
