<?php

namespace UKFast\SDK\eCloud;

use UKFast\SDK\eCloud\Entities\Appliance;
use UKFast\SDK\eCloud\Entities\Appliance\Version\Data;
use UKFast\SDK\Page;

class ApplianceVersionClient extends Client
{
    const MAP = [
        'id' => 'id',
        'appliance_id' => 'applianceId',
        'version' => 'version',
        'script_template' => 'scriptTemplate',
        'vm_template' => 'vmTemplate',
        'active' => 'active',
        'created_at' => 'createdAt',
        'updated_at' => 'updatedAt',
    ];
}
