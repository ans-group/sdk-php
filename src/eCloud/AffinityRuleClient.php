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

    public function getMembers($id, $filters = [])
    {
        $page = $this->paginatedRequest($this->collectionPath . '/' . $id . '/members', 1, 15, $filters);

        if ($page->totalItems() == 0) {
            return [];
        }

        $loadEntity = function ($data) {
            return new AffinityRuleMember($this->apiToFriendly($data, AffinityRuleMember::$entityMap));
        };

        $page->serializeWith($loadEntity);

        $items = $page->getItems();
        if ($page->totalPages() == 1) {
            return $items;
        }

        while ($page->pageNumber() < $page->totalPages()) {
            $page = $this->getPage($page->pageNumber() + 1, 15, $filters);

            $page->serializeWith($loadEntity);
            $items = array_merge(
                $items,
                $page->getItems()
            );
        }
        return $items;
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
