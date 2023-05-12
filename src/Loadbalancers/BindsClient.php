<?php

namespace UKFast\SDK\Loadbalancers;

use UKFast\SDK\Client as BaseClient;
use UKFast\SDK\Loadbalancers\Entities\Bind;
use UKFast\SDK\Traits\PageItems;

class BindsClient extends BaseClient
{
    use PageItems {
        getById as protected;
        deleteById as protected;
        createEntity as protected;
        updateEntity as protected;
        getChildResources as protected;
    }

    protected $collectionPath = 'v2/binds';

    public function getEntityMap()
    {
        return Bind::$entityMap;
    }

    public function loadEntity($data)
    {
        return new Bind($this->apiToFriendly($data, $this->getEntityMap()));
    }
}
