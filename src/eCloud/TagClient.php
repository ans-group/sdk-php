<?php

namespace UKFast\SDK\eCloud;

use UKFast\SDK\eCloud\Entities\Tag;
use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\Traits\PageItems;

class TagClient extends Client implements ClientEntityInterface
{
    use PageItems;

    protected $collectionPath = 'v2/tags';

    public function loadEntity($data)
    {
        return new Tag(
            $this->apiToFriendly($data, $this->getEntityMap())
        );
    }

    public function getEntityMap()
    {
        return Tag::$entityMap;
    }
}
