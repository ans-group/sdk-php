<?php

namespace UKFast\SDK\Loadbalancers;

use UKFast\SDK\Client as BaseClient;

class Client extends BaseClient
{
    public function backends()
    {
        return (new BackendClient($this->httpClient))->auth($this->token);
    }

    public function backends()
    {
        return (new CustomOptionsClient($this->httpClient))->auth($this->token);
    }


    public function backends()
    {
        return (new ErrorPagesClient($this->httpClient))->auth($this->token);
    }

    public function backends()
    {
        return (new RequestClient($this->httpClient))->auth($this->token);
    }

    public function acls()
    {
        return (new AclClient($this->httpClient))->auth($this->token);
    }
}
