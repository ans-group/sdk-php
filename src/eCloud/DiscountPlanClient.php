<?php

namespace UKFast\SDK\eCloud;

use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\Traits\PageItems;
use UKFast\SDK\eCloud\Entities\DiscountPlan;

class DiscountPlanClient extends Client implements ClientEntityInterface
{
    use PageItems;

    protected $collectionPath = 'v2/discount-plans';

    public function getEntityMap()
    {
        return [
            'id' => 'id',
            'name' => 'name',
            'commitment_amount' => 'commitment',
            'commitment_before_discount' => 'threshold',
            'discount_rate' => 'rate',
            'term_length' => 'term',
            'term_start_date' => 'start',
            'term_end_date' => 'end',
            'created_at' => 'createdAt',
            'updated_at' => 'updatedAt',
        ];
    }

    public function loadEntity($data)
    {
        return new DiscountPlan(
            $this->apiToFriendly($data, $this->getEntityMap())
        );
    }
}
