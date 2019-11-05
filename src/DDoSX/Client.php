<?php

namespace UKFast\SDK\DDoSX;

use UKFast\SDK\Client as BaseClient;

class Client extends BaseClient
{
    /**
     * Return a domainClient instance
     *
     * @return DomainClient
     */
    public function domains()
    {
        return (new DomainClient($this->httpClient))->auth($this->token);
    }
}
