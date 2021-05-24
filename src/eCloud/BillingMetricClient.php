<?php

namespace UKFast\SDK\eCloud;

use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\Traits\PageItems;
use UKFast\SDK\eCloud\Entities\BillingMetric;

class BillingMetricClient extends Client implements ClientEntityInterface
{
    use PageItems;

    protected $collectionPath = 'v2/billing-metrics';

    public function getEntityMap()
    {
        return [
            'id' => 'id',
            'vpc_id' => 'vpcId',
            'resource_id' => 'resourceId',
            'key' => 'key',
            'value' => 'value',
            'start' => 'start',
            'end' => 'end',
            'category' => 'category',
            'price' => 'price',
            'created_at' => 'createdAt',
            'updated_at' => 'updatedAt',
        ];
    }

    public function loadEntity($data)
    {
        return new BillingMetric(
            $this->apiToFriendly($data, $this->getEntityMap())
        );
    }
}
