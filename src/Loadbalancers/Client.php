<?php

namespace UKFast\SDK\Loadbalancers;

use UKFast\SDK\Client as BaseClient;

class Client extends BaseClient
{
    protected $basePath = 'loadbalancers/';

    public function acls()
    {
        return (new AclClient($this->httpClient))->auth($this->token);
    }

    public function clusters()
    {
        return (new ClusterClient($this->httpClient))->auth($this->token);
    }

    public function customOptions()
    {
        return (new CustomOptionsClient($this->httpClient))->auth($this->token);
    }

    public function errorPages()
    {
        return (new ErrorPagesClient($this->httpClient))->auth($this->token);
    }

    public function listeners()
    {
        return (new ListenerClient($this->httpClient))->auth($this->token);
    }

    public function targetGroups()
    {
        return (new TargetGroupClient($this->httpClient))->auth($this->token);
    }

    public function targets()
    {
        return (new TargetClient($this->httpClient))->auth($this->token);
    }

    public function vips()
    {
        return (new VipClient($this->httpClient))->auth($this->token);
    }

    public function accessIps()
    {
        return (new AccessIpClient($this->httpClient))->auth($this->token);
    }
}
