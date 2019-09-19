<?php

namespace UKFast\SDK\Domains;

use UKFast\SDK\Client as BaseClient;

class Client extends BaseClient
{
    protected $basePath = 'registrar/';


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
    public function whois()
    {
        return (new WhoisClient($this->httpClient))->auth($this->token);
    }
}
