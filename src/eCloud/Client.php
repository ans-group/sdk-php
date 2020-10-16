<?php

namespace UKFast\SDK\eCloud;

use UKFast\SDK\Client as BaseClient;

class Client extends BaseClient
{
    protected $basePath = 'ecloud/';


    /**
     * @return BaseClient
     */
    public function datastores()
    {
        return (new DatastoreClient($this->httpClient))->auth($this->token);
    }

    /**
     * @return BaseClient
     */
    public function firewalls()
    {
        return (new FirewallClient($this->httpClient))->auth($this->token);
    }

    /**
     * @return BaseClient
     */
    public function hosts()
    {
        return (new HostClient($this->httpClient))->auth($this->token);
    }

    /**
     * @return BaseClient
     */
    public function pods()
    {
        return (new PodClient($this->httpClient))->auth($this->token);
    }

    /**
     * @return BaseClient
     */
    public function sites()
    {
        return (new SiteClient($this->httpClient))->auth($this->token);
    }

    /**
     * @return BaseClient
     */
    public function solutions()
    {
        return (new SolutionClient($this->httpClient))->auth($this->token);
    }

    /**
     * @return BaseClient
     */
    public function templates()
    {
        return (new TemplateClient($this->httpClient))->auth($this->token);
    }

    /**
     * @return BaseClient
     */
    public function virtualMachines()
    {
        return (new VirtualMachineClient($this->httpClient))->auth($this->token);
    }

    /**
     * @return BaseClient
     */
    public function iops()
    {
        return (new IopsClient($this->httpClient))->auth($this->token);
    }

    /**
     * @return BaseClient
     */
    public function appliances()
    {
        return (new ApplianceClient($this->httpClient))->auth($this->token);
    }


    /**
     * @return BaseClient
     */
    public function regions()
    {
        return (new RegionClient($this->httpClient))->auth($this->token);
    }

    /**
     * @return BaseClient
     */
    public function availabilityZones()
    {
        return (new AvailabilityZoneClient($this->httpClient))->auth($this->token);
    }

    /**
     * @return BaseClient
     */
    public function vpcs()
    {
        return (new VpcClient($this->httpClient))->auth($this->token);
    }

    /**
     * @return BaseClient
     */
    public function instances()
    {
        return (new InstanceClient($this->httpClient))->auth($this->token);
    }

    /**
     * @return BaseClient
     */
    public function volumes()
    {
        return (new VolumeClient($this->httpClient))->auth($this->token);
    }

    /**
     * @return BaseClient
     */
    public function floatingIps()
    {
        return (new FloatingIpClient($this->httpClient))->auth($this->token);
    }

    /**
     * @return BaseClient
     */
    public function routers()
    {
        return (new RouterClient($this->httpClient))->auth($this->token);
    }

    /**
     * @return BaseClient
     */
    public function loadBalancerClusters()
    {
        return (new LoadBalancerClusterClient($this->httpClient))->auth($this->token);
    }
}
