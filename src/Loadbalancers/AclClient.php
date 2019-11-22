<?php

namespace UKFast\SDK\Loadbalancers;

use UKFast\SDK\Account\Client as BaseClient;
use UKFast\SDK\Loadbalancers\Entities\Acl;

class AclClient extends BaseClient
{
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
        $page = $this->paginatedRequest('v2/acls', $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return $this->serializeAcl($item);
        });

        return $page;
    }

    /**
     * Gets an individual request
     *
     * @param int $id
     * @return \UKFast\SDK\PSS\Entities\Request
     */
    public function getById($id)
    {
        $response = $this->request("GET", "v2/acls/$id");
        $body = $this->decodeJson($response->getBody()->getContents());
        return $this->serializeAcl($body->data);
    }

    protected function serializeAcl($raw)
    {
        return new Acl([
            'id' => $raw->id,
            'frontendId' => $raw->frontend_id,
            'backendId' => $raw->backend_id,
        ]);
    }
}
