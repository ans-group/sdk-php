<?php

namespace UKFast\SDK\eCloud\Entities;

class Appliance
{
    public $id;
    public $name;
    public $logoUri;
    public $description;
    public $documentationUri;
    public $publisher;
    public $createdAt;

    /**
     * Solution constructor.
     * @param null $item
     */
    public function __construct($item = null)
    {
        if (empty($item)) {
            return;
        }

        $this->id = $item->id;
        $this->name = $item->name;
        $this->logoUri = $item->logo_uri;
        $this->description = $item->description;
        $this->documentationUri = $item->documentation_uri;
        $this->publisher = $item->publisher;
        $this->createdAt = $item->created_at;
    }
}
