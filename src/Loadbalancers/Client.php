<?php

namespace UKFast\SDK\Loadbalancers;

use UKFast\SDK\Client as BaseClient;

class Client extends BaseClient
{
    public function acls()
    {
        return (new AclClient($this->httpClient))->auth($this->token);
    }
}
