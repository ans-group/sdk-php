<?php

namespace UKFast\SDK\eCloud;

use UKFast\SDK\eCloud\Entities\AffinityRuleMember;
use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\Traits\PageItems;

class AffinityRuleMemberClient extends Client implements ClientEntityInterface
{
    /** @use PageItems<AffinityRuleMember> */
    use PageItems;

    protected $collectionPath = 'v2/affinity-rule-members';

    public function getEntityMap()
    {
        return AffinityRuleMember::$entityMap;
    }

    public function loadEntity($data)
    {
        return new AffinityRuleMember(
            $this->apiToFriendly($data, $this->getEntityMap())
        );
    }
}
