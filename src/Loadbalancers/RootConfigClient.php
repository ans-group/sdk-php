<?php

namespace UKFast\SDK\Loadbalancers;

use UKFast\SDK\Client;
use UKFast\SDK\Loadbalancers\Entities\Configuration;
use UKFast\SDK\SelfResponse;

class RootConfigClient extends Client
{
    const MAP = [
        'request_id' => 'requestId',
        'group_id' => 'groupId',
    ];
    
    protected $basePath = 'loadbalancers/';

    /**
     * Gets a paginated response of all Root configs
     *
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return \UKFast\SDK\Page
     */
    public function getPage($page = 1, $perPage = 15, $filters = [])
    {
        $filters = $this->apiToFriendly($filters, self::MAP);
        $page = $this->paginatedRequest('v2/configurations', $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return $this->serializeConfiguration($item);
        });

        return $page;
    }

    /**
     * Gets an individual root config
     *
     * @param int $id
     * @return \UKFast\SDK\PSS\Entities\Request
     */
    public function getById($id)
    {
        $response = $this->request("GET", "v2/configurations/$id");
        $body = $this->decodeJson($response->getBody()->getContents());
        return $this->serializeConfiguration($body->data);
    }

    /**
     * Creates a new config
     * @param \UKFast\SDK\Loadbalancers\Entities\Configuration
     * @return UKFast\SDK\SelfResponse
     */
    public function create($config)
    {
        $json = json_encode($this->friendlyToApi($config, self::MAP));
        $response = $this->post("v2/configurations", $json);
        $response = $this->decodeJson($response->getBody()->getContents());
        
        return (new SelfResponse($response))
            ->setClient($this)
            ->serializeWith(function ($response) {
                return $this->serializeConfiguration($response->data);
            });
    }

    /**
     * @param object $raw
     */
    protected function serializeConfiguration($raw)
    {
        return new Configuration($this->apiToFriendly($raw, self::MAP));
    }
}
