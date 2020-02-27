<?php

namespace UKFast\SDK\DRaaS;

use UKFast\SDK\Client as BaseClient;

class Client extends BaseClient
{
    protected $basePath = 'draas/';

    /**
     * @return SolutionClient
     */
    public function solutions()
    {
        return (new SolutionClient($this->httpClient))->auth($this->token);
    }

    /**
     * @return ResourcesClient
     */
    public function resources()
    {
        return (new ResourcesClient($this->httpClient))->auth($this->token);
    }
}
