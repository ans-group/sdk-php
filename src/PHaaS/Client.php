<?php

namespace UKFast\PHaaS;

use UKFast\Client as BaseClient;

class Client extends BaseClient
{
    protected $basePath = 'phaas/';

    public function domains($authToken)
    {
        return (new DomainClient())->auth($authToken);
    }
}