<?php

namespace UKFast\SDK\Licenses;

use UKFast\SDK\Client as BaseClient;

class Client extends BaseClient
{
    protected $basePath = 'licenses/';

    /**
     * @return BaseClient
     */
    public function licenses()
    {
        return (new LicensesClient($this->httpClient))->auth($this->token);
    }
}
