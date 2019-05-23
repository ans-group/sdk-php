<?php

namespace UKFast\PHaaS;

use UKFast\Client as BaseClient;

class Client extends BaseClient
{
    protected $basePath = 'phaas/';

    /**
     * @return BaseClient
     */
    public function domains()
    {
        return (new DomainClient())->auth($this->token);
    }

    public function users()
    {
        return (new UserClient())->auth($this->token);
    }
}
