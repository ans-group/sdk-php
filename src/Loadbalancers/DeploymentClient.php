<?php

namespace UKFast\SDK\Loadbalancers;

use UKFast\SDK\Client as BaseClient;
use UKFast\SDK\Loadbalancers\Entities\Deployment;

class DeploymentClient extends BaseClient
{
    const MAP = [
        'cluster_id' => 'clusterId',
        'requested_by_type' => 'requestedByType',
        'requested_by_id' => 'requestedById',
        'pss_id' => 'pssId',
        'created_at' => 'createdAt',
        'updated_at' => 'updatedAt',
    ];

    protected $basePath = 'loadbalancers/';

    /**
     * @param int $clusterId
     * @return bool
     */
    public function create($clusterId)
    {
        $response = $this->post("v2/clusters/$clusterId/deploy");

        return $response->getStatusCode() == 204;
    }

    /**
     * @param int $clusterId
     * @return bool
     */
    public function validate($clusterId)
    {
        $response = $this->get("v2/clusters/$clusterId/validate");

        return $response->getStatusCode() == 200;
    }
    
    public function getPage($page = 1, $perPage = 15, $filters = [])
    {
        $filters = $this->friendlyToApi($filters, self::MAP);
        $page = $this->paginatedRequest('v2/deployments', $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return new Deployment($this->apiToFriendly($item, self::MAP));
        });

        return $page;
    }

    public function getById($id)
    {
        $response = $this->request("GET", "v2/deployments/$id");
        $body = $this->decodeJson($response->getBody()->getContents());
        
        return new Deployment($this->apiToFriendly($body->data, self::MAP));
    }
}
