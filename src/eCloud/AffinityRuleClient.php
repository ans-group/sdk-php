<?php

namespace UKFast\SDK\eCloud;

use UKFast\SDK\eCloud\Entities\AffinityRule;
use UKFast\SDK\eCloud\Entities\AffinityRuleMember;
use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\Traits\PageItems;

class AffinityRuleClient extends Client implements ClientEntityInterface
{
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

    /**
     * Assigns an instance to a rule
     * @param $id
     * @param $instanceId
     * @return bool
     */
    public function assignMember($id, $instanceId)
    {
        $response = $this->post(
            $this->collectionPath . '/' . $id . '/members',
            json_encode([ 'instance_id' => $instanceId ])
        );
        return $response->getStatusCode() == 202;
    }
    /**
     * Detaches an instance from a rule
     * @param $id
     * @param $memberId
     * @return bool
     */
    public function detachMember($id, $memberId)
    {
        $response = $this->delete($this->collectionPath . '/' . $id . '/members/' . $memberId);
        return $response->getStatusCode() == 202;
    }
}
