<?php

namespace UKFast\SDK\Loadbalancers;

use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\Loadbalancers\Entities\ErrorPage;
use UKFast\SDK\Traits\PageItems;

class ErrorPageClient extends Client implements ClientEntityInterface
{
    use PageItems;

    protected $collectionPath = 'v2/error-pages';

    public function getEntityMap()
    {
        return [
            'id' => 'id',
            'target_group_id' => 'targetGroupId',
            'listener_id' => 'listenerId',
            'status_codes' => 'statusCodes',
            'content' => 'content',
            'created_at' => 'createdAt',
            'updated_at' => 'updatedAt',
        ];
    }

    public function loadEntity($data)
    {
        return new ErrorPage(
            $this->apiToFriendly($data, $this->getEntityMap())
        );
    }
}
