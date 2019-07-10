<?php

namespace UKFast\SDK\LTaaS;

use UKFast\SDK\Client as BaseClient;

class Client extends BaseClient
{
    protected $basePath = 'load-testing/';

    /**
     * @return BaseClient
     */
    public function domains()
    {
        return (new DomainClient($this->httpClient))->auth($this->token);
    }
}