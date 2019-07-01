<?php

namespace UKFast\SDK\Account;

use UKFast\SDK\Client as BaseClient;

class Client extends BaseClient
{
    protected $basePath = 'account/';


    /**
     * @return BaseClient
     */
    public function company()
    {
        return (new CompanyClient($this->httpClient))->auth($this->token);
    }

    /**
     * @return BaseClient
     */
    public function contacts()
    {
        return (new ContactClient($this->httpClient))->auth($this->token);
    }

    /**
     * @return BaseClient
     */
    public function credits()
    {
        return (new CreditClient($this->httpClient))->auth($this->token);
    }
}
