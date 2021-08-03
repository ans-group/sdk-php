<?php

namespace UKFast\SDK\Loadbalancers;

use UKFast\SDK\Client as BaseClient;
use UKFast\SDK\Loadbalancers\Entities\Acl;
use UKFast\SDK\SelfResponse;

class AclClient extends BaseClient
{
    const MAP = [
        'listener_id' => 'listenerId',
        'target_group_id' => 'targetGroupId',
        'created_at' => 'createdAt',
        'updated_at' => 'updatedAt',
    ];

    protected $basePath = 'loadbalancers/';

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
        $filters = $this->friendlyToApi($filters, self::MAP);
        $page = $this->paginatedRequest('v2/acls', $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return new Acl($this->apiToFriendly($item, self::MAP));
        });

        return $page;
    }

    /**
     * Gets an individual ACL
     *
     * @param int $id
     * @return \UKFast\SDK\Loadbalancers\Entities\Acl
     */
    public function getById($id)
    {
        $response = $this->request("GET", "v2/acls/$id");
        $body = $this->decodeJson($response->getBody()->getContents());
        return new Acl($this->apiToFriendly($body->data, self::MAP));
    }
    
    /**
     * Delete an individual ACL
     * @param $id
     */
    public function deleteById($id)
    {
        $response = $this->delete("v2/acls/$id");
        return $response->getStatusCode() == 204;
    }

    /**
     * @param \UKFast\SDK\Loadbalancers\Entities\Acl
     * @return \UKFast\SDK\SelfResponse
     */
    public function create($acl)
    {
        $json = json_encode($this->friendlyToApi($acl, self::MAP));
        $response = $this->post("v2/acls", $json);
        $response = $this->decodeJson($response->getBody()->getContents());
        
        return (new SelfResponse($response))
            ->setClient($this)
            ->serializeWith(function ($body) {
                return new Acl($this->apiToFriendly($body->data, self::MAP));
            });
    }
    
    /**
     * @param Acl $acl
     * @return SelfResponse
     */
    public function update(Acl $acl)
    {
        $data = json_encode($this->friendlyToApi($acl, static::MAP));
        $response = $this->patch("v2/acls/{$acl->id}", $data);
        $body = $this->decodeJson($response->getBody()->getContents());

        return (new SelfResponse($body))
            ->setClient($this)
            ->serializeWith(function ($response) {
                return new Acl($this->apiToFriendly($body->data, self::MAP));
            });
    }
}
