<?php

namespace UKFast\SDK\Loadbalancers;

use UKFast\SDK\Client;
use UKFast\SDK\Loadbalancers\Entities\CustomOption;
use UKFast\SDK\SelfResponse;

class CustomOptionsClient extends Client
{
    const MAP = [
        'frontend_id' => 'frontendId',
        'backend_id' => 'backendId',
        'backend_servers_id' => 'backendServersId',
    ];

    protected $basePath = 'loadbalancers/';

    /**
     * Gets a paginated response of all custom options
     *
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return \UKFast\SDK\Page
     */
    public function getPage($page = 1, $perPage = 15, $filters = [])
    {
        $filters = $this->friendlyToApi($filters, self::MAP);
        $page = $this->paginatedRequest('v2/custom-options', $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return $this->serializeCustomOption($item);
        });
        return $page;
    }

    /**
     * Gets an individual option
     *
     * @param int $id
     * @return \UKFast\SDK\Loadbalancers\Entities\CustomOption
     */
    public function getById($id)
    {
        $response = $this->request("GET", "v2/custom-options/$id");
        $body = $this->decodeJson($response->getBody()->getContents());
        return $this->serializeCustomOption($body->data);
    }

    /**
     * Creates a custom option
     * @param \UKFast\SDK\Loadbalancers\Entities\CustomOption $customOption
     * @return \UKFast\SDK\SelfResponse
     */
    public function create($customOption)
    {
        $response = $this->post('v2/custom-options', json_encode($this->friendlyToApi(
            $customOption,
            self::MAP
        )));

        $response  = $this->decodeJson($response->getBody()->getContents());
        return (new SelfResponse($response))
            ->setClient($this)
            ->serializeWith(function ($response) {
                return $this->serializeCustomOption($response->data);
            });
    }

    /**
     * @param object
     * @return \UKFast\SDK\Loadbalancers\Entities\CustomOption
     */
    protected function serializeCustomOption($raw)
    {
        return new CustomOption($this->apiToFriendly($raw, self::MAP));
    }
}
