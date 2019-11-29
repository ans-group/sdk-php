<?php

namespace UKFast\SDK\DDoSX;

use UKFast\SDK\Client as BaseClient;

class Client extends BaseClient
{
    /**
     * @inheritDoc
     */
    protected $basePath = 'ddosx/';

    /**
     * Return a domainClient instance
     *
     * @return DomainClient
     */
    public function domains()
    {
        return (new DomainClient($this->httpClient))->auth($this->token);
    }

    /**
     * Return a DomainVerificationClient instance
     *
     * @return DomainVerificationClient
     */
    public function domainVerification()
    {
        return (new DomainVerificationClient($this->httpClient))->auth($this->token);
    }
}
