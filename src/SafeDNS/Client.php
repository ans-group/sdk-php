<?php

namespace UKFast\SDK\SafeDNS;

use UKFast\SDK\Client as BaseClient;

class Client extends BaseClient
{
    protected $basePath = 'safedns/';


    /**
     * @return BaseClient
     */
    public function zones()
    {
        return (new ZoneClient($this->httpClient))->auth($this->token);
    }

    /**
     * @return BaseClient
     */
    public function records()
    {
        return (new RecordClient($this->httpClient))->auth($this->token);
    }
}
