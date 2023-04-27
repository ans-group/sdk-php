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

    /**
     * @return ReportClient
     */
    public function reports()
    {
        return (new ReportClient($this->httpClient))->auth($this->token);
    }

    /*
     * @return RecommendationsClient
     */
    public function recommendations()
    {
        return (new RecommendationsClient($this->httpClient))->auth($this->token);
    }

    /**
     * @return ValidationClient
     */
    public function validation()
    {
        return (new ValidationClient($this->httpClient))->auth($this->token);
    }

    public function dcv()
    {
        return (new DcvClient($this->httpClient))->auth($this->token);
    }
}
