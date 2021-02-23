<?php

namespace UKFast\SDK\Loadbalancers;

use UKFast\SDK\Client as BaseClient;
use UKFast\SDK\Loadbalancers\Entities\Vip;
use UKFast\SDK\SelfResponse;

class VipClient extends BaseClient
{
    const MAP = [
        'cluster_id' => 'clusterId',
        'mac_address' => 'macAddress',
        'internal_cidr' => 'internalCidr',
        'external_cidr' => 'externalCidr',
    ];

    protected $basePath = 'loadbalancers/';

    /**
     * Gets a paginated response of all Vips
     *
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return \UKFast\SDK\Page
     */
    public function getPage($page = 1, $perPage = 15, $filters = [])
    {
        $filters = $this->friendlyToApi($filters, self::MAP);
        $page = $this->paginatedRequest('v2/vips', $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return $this->serializeVip($item);
        });

        return $page;
    }

    /**
     * Gets an individual vip
     *
     * @param int $id
     * @return \UKFast\SDK\Loadbalancers\Entities\Vip
     */
    public function getById($id)
    {
        $response = $this->request("GET", "v2/vips/$id");
        $body = $this->decodeJson($response->getBody()->getContents());
        return $this->serializeVip($body->data);
    }

    /**
     * Creates a new vip
     * @param \UKFast\SDK\Loadbalancers\Entities\Vip
     * @return UKFast\SDK\SelfResponse
     */
    public function create($vip)
    {
        $json = json_encode($this->friendlyToApi($vip, self::MAP));
        $response = $this->post("v2/vips", $json);
        $response = $this->decodeJson($response->getBody()->getContents());
        
        return (new SelfResponse($response))
            ->setClient($this)
            ->serializeWith(function ($response) {
                return $this->serializeVip($response->data);
            });
    }

    /**
     * @return \UKFast\SDK\Loadbalancers\Entities\Vip
     */
    public function serializeVip($raw)
    {
        return new Vip($this->apiToFriendly($raw, self::MAP));
    }
}
