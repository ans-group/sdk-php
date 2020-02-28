<?php

namespace UKFast\SDK\DRaaS;

use UKFast\SDK\Client as BaseClient;

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
     * @return IopsTiersClient
     */
    public function iops()
    {
        return (new IopsTiersClient($this->httpClient))->auth($this->token);
    }
}
