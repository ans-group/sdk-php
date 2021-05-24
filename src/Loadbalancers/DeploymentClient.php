<?php

namespace UKFast\SDK\Loadbalancers;

use UKFast\SDK\Client as BaseClient;

class DeploymentClient extends BaseClient
{
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
}
