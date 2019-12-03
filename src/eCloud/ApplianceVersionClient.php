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
        'description' => 'description',
        'script_template' => 'scriptTemplate',
        'created_at' => 'createdAt',
        'updated_at' => 'updatedAt',
    ];
}
