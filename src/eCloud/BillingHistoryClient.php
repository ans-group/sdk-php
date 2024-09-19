<?php

namespace UKFast\SDK\eCloud;

use UKFast\SDK\eCloud\Entities\BillingHistory;
use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\Traits\PageItems;

class BillingHistoryClient extends Client implements ClientEntityInterface
{
    use PageItems;

    protected $collectionPath = 'v2/billing-histories';

    public function getEntityMap()
    {
        return BillingHistory::$entityMap;
    }

    public function loadEntity($data)
    {
        return new BillingHistory(
            $this->apiToFriendly($data, BillingHistory::$entityMap)
        );
    }
}
