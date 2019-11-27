<?php

namespace UKFast\SDK\Loadbalancers;

use UKFast\SDK\Account\Client as BaseClient;
use UKFast\SDK\Loadbalancers\Entities\Acl;
use UKFast\SDK\Loadbalancers\Entities\Conditon;
use UKFast\SDK\Loadbalancers\Entities\Header;
use UKFast\SDK\Loadbalancers\Entities\Match;
use UKFast\SDK\SelfResponse;

class AclClient extends BaseClient
{
    const MAP = [
        'frontend_id' => 'frontendId',
        'backend_id' => 'backendId',
    ];

    const MATCH_MAP = [
        'header_id' => 'headerId',
        'match_case' => 'matchCase',
    ];

    const HEADER_MAP = [];

    const FREETYPE_MAP = [
        'header_id' => 'headerId',
    ];

    const CONDITION_MAP = [];

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

    public function getHeaders($id, $page = 1, $perPage = 15, $filters = [])
    {
        $filters = $this->friendlyToApi($filters, self::HEADER_MAP);
        $page = $this->paginatedRequest("v2/acls/$id/headers", $page, $perPage, $filters);

        $page->serializeWith(function ($item) {
            return new Header($this->apiToFriendly($item, self::HEADER_MAP));
        });
        return $page;
    }

    public function getMatches($id, $page = 1, $perPage = 15, $filters = [])
    {
        $filters = $this->friendlyToApi($filters, self::MATCH_MAP);
        $page = $this->paginatedRequest("v2/acls/$id/matches", $page, $perPage, $filters);

        $page->serializeWith(function ($item) {
            return new Match($this->apiToFriendly($item, self::HEADER_MAP));
        });
        return $page;
    }

    public function getFreetypes($id, $page = 1, $perPage = 15, $filters = [])
    {
        $filters = $this->friendlyToApi($filters, self::FREETYPE_MAP);
        $page = $this->paginatedRequest("v2/acls/$id/freetypes", $page, $perPage, $filters);

        $page->serializeWith(function ($item) {
            return new Freetype($this->apiToFriendly($item, self::FREETYPE_MAP));
        });
        return $page;
    }

    public function getConditions($id, $page = 1, $perPage = 15, $filters = [])
    {
        $filters = $this->friendlyToApi($filters, self::CONDITION_MAP);
        $page = $this->paginatedRequest("v2/acls/$id/conditions", $page, $perPage, $filters);

        $page->serializeWith(function ($item) {
            return new Conditon($this->apiToFriendly($item, self::CONDITION_MAP));
        });
        return $page;
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

    public function addHeader($aclId, $header)
    {
        $json = json_encode($this->friendlyToApi($header, self::HEADER_MAP));
        $response = $this->post("v2/acls/$aclId/headers", $json);
        $response = $this->decodeJson($response->getBody()->getContents());
        
        return (new SelfResponse($response))
            ->setClient($this)
            ->serializeWith(function ($body) {
                return new Match($this->apiToFriendly($body->data, self::HEADER_MAP));
            });
    }

    public function addMatch($aclId, $match)
    {
        $json = json_encode($this->friendlyToApi($match, self::MATCH_MAP));
        $response = $this->post("v2/acls/$aclId/matches", $json);
        $response = $this->decodeJson($response->getBody()->getContents());
        
        return (new SelfResponse($response))
            ->setClient($this)
            ->serializeWith(function ($body) {
                return new Match($this->apiToFriendly($body->data, self::MATCH_MAP));
            });
    }

    public function addCondition($aclId, $condition)
    {
        $json = json_encode($this->friendlyToApi($condition, self::CONDITION_MAP));
        $response = $this->post("v2/acls/$aclId/conditions", $json);
        $response = $this->decodeJson($response->getBody()->getContents());
        
        return (new SelfResponse($response))
            ->setClient($this)
            ->serializeWith(function ($body) {
                return new Condition($this->apiToFriendly($body->data, self::CONDITION_MAP));
            });
    }
}
