<?php

namespace UKFast\eCloud;

use UKFast\Client as BaseClient;

class Client extends BaseClient
{
    protected $basePath = 'ecloud/';


    /**
     * @return BaseClient
     */
    public function datastores()
    {
        return (new DatastoreClient())->auth($this->token);
    }

    /**
     * @return BaseClient
     */
    public function firewalls()
    {
        return (new FirewallClient())->auth($this->token);
    }

    /**
     * @return BaseClient
     */
    public function hosts()
    {
        return (new HostClient())->auth($this->token);
    }

    /**
     * @return BaseClient
     */
    public function pods()
    {
        return (new PodClient())->auth($this->token);
    }

    /**
     * @return BaseClient
     */
    public function sites()
    {
        return (new SiteClient())->auth($this->token);
    }

    /**
     * @return BaseClient
     */
    public function solutions()
    {
        return (new SolutionClient())->auth($this->token);
    }

    /**
     * @return BaseClient
     */
    public function virtualMachines()
    {
        return (new VirtualMachineClient())->auth($this->token);
    }
}
