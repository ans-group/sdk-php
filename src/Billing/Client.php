<?php

namespace UKFast\SDK\Billing;

use UKFast\SDK\Client as BaseClient;

class Client extends BaseClient
{
    protected $basePath = 'billing/';

    /**
     * @return BaseClient
     */
    public function recurringCosts()
    {
        return (new RecurringCostClient($this->httpClient))->auth($this->token);
    }
}
