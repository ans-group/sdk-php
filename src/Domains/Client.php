<?php

namespace UKFast\Domains;

use UKFast\Client as BaseClient;

class Client extends BaseClient
{
    protected $basePath = 'registrar/';


    /**
     * @return BaseClient
     */
    public function domains()
    {
        return (new DomainClient())->auth($this->token);
    }

    /**
     * @return BaseClient
     */
    public function whois()
    {
        return (new WhoisClient())->auth($this->token);
    }
}
