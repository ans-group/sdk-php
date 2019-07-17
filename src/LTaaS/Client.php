<?php

namespace UKFast\SDK\LTaaS;

use UKFast\SDK\Client as BaseClient;

class Client extends BaseClient
{
    protected $basePath = 'ltaas/';

    /**
     * @return BaseClient
     */
    public function domains()
    {
        return (new DomainClient($this->httpClient))->auth($this->token);
    }

    /**
     * @return BaseClient
     */
    public function jobs()
    {
        return (new JobClient($this->httpClient))->auth($this->token);
    }

    /**
     * @return BaseClient
     */
    public function tests()
    {
        return (new TestClient($this->httpClient))->auth($this->token);
    }
}
