<?php

namespace UKFast\Account;

use UKFast\Client as BaseClient;

class Client extends BaseClient
{
    protected $basePath = 'account/';


    /**
     * @return BaseClient
     */
    public function company()
    {
        return (new CompanyClient())->auth($this->token);
    }

    /**
     * @return BaseClient
     */
    public function contacts()
    {
        return (new ContactClient())->auth($this->token);
    }

    /**
     * @return BaseClient
     */
    public function credits()
    {
        return (new CreditClient())->auth($this->token);
    }
}
