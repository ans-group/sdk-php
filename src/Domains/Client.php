<?php

namespace UKFast\SDK\Domains;

use UKFast\SDK\Client as BaseClient;

class Client extends BaseClient
{
    protected $basePath = 'registrar/';


    /**
     * @return DomainClient
     */
    public function domains()
    {
        return (new DomainClient($this->httpClient))->auth($this->token);
    }

    /**
     * @return WhoisClient
     */
    public function whois()
    {
        return (new WhoisClient($this->httpClient))->auth($this->token);
    }

    /**
     * @return DomainRegistrationClient
     */
    public function registrar()
    {
        return (new DomainRegistrationClient($this->httpClient))->auth($this->token);
    }

    /**
     * @return LookupClient
     */
    public function lookup()
    {
        return (new LookupClient($this->httpClient))->auth($this->token);
    }
}
