<?php

namespace UKFast\SDK\Loadbalancers;

use UKFast\SDK\Account\Client as BaseClient;
use UKFast\SDK\Loadbalancers\Entities\Acl;
use UKFast\SDK\SelfResponse;

class AclClient extends BaseClient
{
    const MAP = [
        'frontend_id' => 'frontendId',
        'backend_id' => 'backendId',
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
            return $this->serializeAcl($item);
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
        return $this->serializeAcl($body->data);
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
            ->serializeWith(function ($response) {
                return $this->serializeAcl($response->data);
            });
    }

    /**
     * @param object $raw
     * @return \UKFast\SDK\Loadbalancers\Entities\Acl
     */
    protected function serializeAcl($raw)
    {
        return new Acl($this->apiToFriendly($raw, self::MAP));
    }
}
