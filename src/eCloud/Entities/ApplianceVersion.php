<?php

namespace UKFast\SDK\eCloud\Entities;

class ApplianceVersion
{
    public $id;
    public $applianceId;
    public $version;
    public $scriptTemplate;
    public $vmTemplate;
    public $active;
    public $createdAt;
    public $updatedAt;

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
        $this->applianceId = $item->appliance_id;
        $this->version = $item->version;
        $this->scriptTemplate = $item->script_template;
        $this->vmTemplate = $item->vm_template;
        $this->active = $item->active;
        $this->createdAt = $item->created_at;
        $this->updatedAt = $item->updated_at;
    }
}
