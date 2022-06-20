<?php

namespace UKFast\SDK\eCloud;

use UKFast\SDK\eCloud\Entities\AffinityRuleMember;
use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\Traits\PageItems;

class AffinityRuleMemberClient extends Client implements ClientEntityInterface
{
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

    /**
     * Assigns an instance to a rule
     * @param $affinityRuleId
     * @param $instanceId
     * @return bool
     */
    public function assignMember($affinityRuleId, $instanceId)
    {
        $response = $this->post(
            $this->collectionPath,
            json_encode([
                'instance_id' => $instanceId,
                'affinity_rule_id' => $affinityRuleId
            ])
        );
        return $response->getStatusCode() == 202;
    }

    /**
     * Detaches an instance from a rule
     * @param $memberId
     * @return bool
     */
    public function detachMember($memberId)
    {
        $response = $this->delete($this->collectionPath . '/' . $memberId);
        return $response->getStatusCode() == 202;
    }
}
