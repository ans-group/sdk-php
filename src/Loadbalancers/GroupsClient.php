<?php

namespace UKFast\SDK\Loadbalancers;

use UKFast\SDK\Client;
use UKFast\SDK\Loadbalancers\Entities\Group;
use UKFast\SDK\SelfResponse;

class GroupsClient extends Client
{
    /**
     * Gets a paginated response of all ACLs
     *
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return \UKFast\SDK\Page
     */
    public function getPage($page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest('v2/groups', $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return $this->serializeGroup($item);
        });

        return $page;
    }

    /**
     * Gets an individual request
     *
     * @param int $id
     * @return \UKFast\SDK\Loadbalancers\Entities\Vip
     */
    public function getById($id)
    {
        $response = $this->request("GET", "v2/groups/$id");
        $body = $this->decodeJson($response->getBody()->getContents());
        return $this->serializeGroup($body->data);
    }

    public function create($group)
    {
        $response = $this->post("v2/groups", json_encode($group->toArray()));
        $response = $this->decodeJson($response->getBody()->getContents());
        
        return (new SelfResponse($response))
            ->setClient($this)
            ->serializeWith(function ($response) {
                return $this->serializeGroup($response->data);
            });
    }

    /**
     * @return \UKFast\SDK\Loadbalancers\Entities\Vip
     */
    public function serializeGroup($raw)
    {
        return new Group([
            'id' => $raw->id,
            'name' => $raw->name,
        ]);
    }
}
