<?php

namespace UKFast\SSL;

use UKFast\Client as BaseClient;

class Client extends BaseClient
{
    protected $basePath = 'ssl/';


    /**
     * @return BaseClient
     */
    public function certificates()
    {
        return (new CertificateClient())->auth($this->token);
    }
}
