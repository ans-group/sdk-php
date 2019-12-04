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

    public function frontends()
    {
        return (new FrontendClient($this->httpClient))->auth($this->token);
    }

    public function groups()
    {
        return (new GroupClient($this->httpClient))->auth($this->token);
    }

    public function groups()
    {
        return (new RootConfigClient($this->httpClient))->auth($this->token);
    }

    public function groups()
    {
        return (new VipClient($this->httpClient))->auth($this->token);
    }
}
