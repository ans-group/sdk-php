<?php

namespace UKFast\SDK\Domains\Entities;

class Registrar
{
    public $name;
    public $url;
    public $tag;
    public $ianaId;


    /**
     * Registrar constructor.
     * @param null $item
     */
    public function __construct($item = null)
    {
        if (empty($item)) {
            return;
        }

        $this->name = $item->name;

        if (isset($item->url)) {
            $this->url = $item->url;
        }

        if (isset($item->tag)) {
            $this->tag = $item->tag;
        }

        if (isset($item->iana_id)) {
            $this->ianaId = $item->iana_id;
        } elseif (isset($item->id)) {
            $this->ianaId = $item->id;
        }
    }
}
