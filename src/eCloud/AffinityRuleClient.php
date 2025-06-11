<?php

namespace UKFast\SDK\eCloud;

use UKFast\SDK\eCloud\Entities\AffinityRule;
use UKFast\SDK\eCloud\Entities\AffinityRuleMember;
use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\Traits\PageItems;

class AffinityRuleClient extends Client implements ClientEntityInterface
{
    /** @use PageItems<AffinityRule> */
    use PageItems;

    protected $collectionPath = 'v2/affinity-rules';

    public function getEntityMap()
    {
        return AffinityRule::$entityMap;
    }

    public function loadEntity($data)
    {
        return new AffinityRule(
            $this->apiToFriendly($data, $this->getEntityMap())
        );
    }

    /**
     * @param $id
     * @param $filters
     * @return array
     */
    public function getMembers($id, $filters = [])
    {
        return $this->getChildResources($id, 'members', function ($data) {
            return new AffinityRuleMember($this->apiToFriendly($data, AffinityRuleMember::$entityMap));
        }, $filters);
    }
}
