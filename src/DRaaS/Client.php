<?php

namespace UKFast\SDK\DRaaS;

use UKFast\SDK\Client as BaseClient;
use UKFast\SDK\DRaaS\Entities\ComputeResources;

class Client extends BaseClient
{
    protected $basePath = 'draas/';

    /**
     * @return BaseClient
     */
    public function solutions()
    {
        return (new SolutionClient($this->httpClient))->auth($this->token);
    }

    /**
     * @return ComputeResourcesClient
     */
    public function computeResources()
    {
        return (new ComputeResourcesClient($this->httpClient))->auth($this->token);
    }
}
