<?php

namespace UKFast\SDK\Billing;

use UKFast\SDK\Billing\Entities\Subscription;
use UKFast\SDK\Traits\PageItems;

class SubscriptionClient extends Client
{
    use PageItems;

    protected $collectionPath = 'v2/subscriptions';

    public function loadEntity($data)
    {
        return new Subscription(
            $this->apiToFriendly($data, $this->getEntityMap())
        );
    }

    /**
     * @return array<string, string>
     */
    public function getEntityMap()
    {
        return Subscription::$entityMap;
    }
}
