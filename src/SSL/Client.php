<?php

namespace UKFast\SDK\SSL;

use UKFast\SDK\Client as BaseClient;

class Client extends BaseClient
{
    protected $basePath = 'ssl/';


    /**
     * @return BaseClient
     */
    public function certificates()
    {
        return (new CertificateClient($this->httpClient))->auth($this->token);
    }
}
