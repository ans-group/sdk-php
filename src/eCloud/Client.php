<?php

namespace UKFast\SDK\eCloud;

use UKFast\SDK\Client as BaseClient;

class Client extends BaseClient
{
    protected $basePath = 'ecloud/';

    /**
     * eCloud v1
     */

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
    public function ipAddresses()
    {
        return (new IpAddressesClient($this->httpClient))->auth($this->token);
    }

    /**
     * @return BaseClient
     */
    public function appliances()
    {
        return (new ApplianceClient($this->httpClient))->auth($this->token);
    }

    /**
     * eCloud v2
     */

    /**
     * @return RegionClient
     */
    public function regions()
    {
        return (new RegionClient($this->httpClient))->auth($this->token);
    }

    /**
     * @return AvailabilityZoneClient
     */
    public function availabilityZones()
    {
        return (new AvailabilityZoneClient($this->httpClient))->auth($this->token);
    }

    /**
     * @return VpcClient
     */
    public function vpcs()
    {
        return (new VpcClient($this->httpClient))->auth($this->token);
    }

    /**
     * @return ImageClient
     */
    public function images()
    {
        return (new ImageClient($this->httpClient))->auth($this->token);
    }

    /**
     * @return InstanceClient
     */
    public function instances()
    {
        return (new InstanceClient($this->httpClient))->auth($this->token);
    }

    /**
     * @return VolumeClient
     */
    public function volumes()
    {
        return (new VolumeClient($this->httpClient))->auth($this->token);
    }

    /**
     * @return FloatingIpClient
     */
    public function floatingIps()
    {
        return (new FloatingIpClient($this->httpClient))->auth($this->token);
    }

    /**
     * @return RouterClient
     */
    public function routers()
    {
        return (new RouterClient($this->httpClient))->auth($this->token);
    }

    /**
     * @return RouterThroughputClient
     */
    public function routerThroughputs()
    {
        return (new RouterThroughputClient($this->httpClient))->auth($this->token);
    }

    /**
     * @return FirewallPolicyClient
     */
    public function firewallPolicies()
    {
        return (new FirewallPolicyClient($this->httpClient))->auth($this->token);
    }

    /**
     * @return FirewallRuleClient
     */
    public function firewallRules()
    {
        return (new FirewallRuleClient($this->httpClient))->auth($this->token);
    }

    /**
     * @return FirewallRulePortClient
     */
    public function firewallRulePorts()
    {
        return (new FirewallRulePortClient($this->httpClient))->auth($this->token);
    }

    /**
     * @return MonitoringGatewaySpecificationClient
     */
    public function monitoringGatewaySpecifications()
    {
        return (new MonitoringGatewaySpecificationClient($this->httpClient))->auth($this->token);
    }

    /**
     * @return MonitoringGatewayClient
     */
    public function monitoringGateways()
    {
        return (new MonitoringGatewayClient($this->httpClient))->auth($this->token);
    }

    /**
     * @return NetworkClient
     */
    public function networks()
    {
        return (new NetworkClient($this->httpClient))->auth($this->token);
    }

    /**
     * @return NetworkPolicyClient
     */
    public function networkPolicies()
    {
        return (new NetworkPolicyClient($this->httpClient))->auth($this->token);
    }

    /**
     * @return NetworkRuleClient
     */
    public function networkRules()
    {
        return (new NetworkRuleClient($this->httpClient))->auth($this->token);
    }

    /**
     * @return NetworkRulePortClient
     */
    public function networkRulePorts()
    {
        return (new NetworkRulePortClient($this->httpClient))->auth($this->token);
    }

    /**
     * @return BillingMetricClient
     */
    public function billingMetrics()
    {
        return (new BillingMetricClient($this->httpClient))->auth($this->token);
    }

    /**
     * @return DiscountPlanClient
     */
    public function discountPlans()
    {
        return (new DiscountPlanClient($this->httpClient))->auth($this->token);
    }

    /**
     * @return HostGroupClient
     */
    public function hostGroups()
    {
        return (new HostGroupClient($this->httpClient))->auth($this->token);
    }

    /**
     * @return HostSpecClient
     */
    public function hostSpecs()
    {
        return (new HostSpecClient($this->httpClient))->auth($this->token);
    }

    /**
     * @return DedicatedHostClient
     */
    public function dedicatedHosts()
    {
        return (new DedicatedHostClient($this->httpClient))->auth($this->token);
    }

    /**
     * @return VpnSessionClient
     */
    public function vpnSessions()
    {
        return (new VpnSessionClient($this->httpClient))->auth($this->token);
    }

    /**
     * @return VpnServiceClient
     */
    public function vpnServices()
    {
        return (new VpnServiceClient($this->httpClient))->auth($this->token);
    }

    /**
     * @return VpnEndpointClient
     */
    public function vpnEndpoints()
    {
        return (new VpnEndpointClient($this->httpClient))->auth($this->token);
    }

    /**
     * @return VpnProfileGroupClient
     */
    public function vpnProfileGroups()
    {
        return (new VpnProfileGroupClient($this->httpClient))->auth($this->token);
    }

    /**
     * @return VolumeGroupClient
     */
    public function volumeGroups()
    {
        return (new VolumeGroupClient($this->httpClient))->auth($this->token);
    }

    /**
     * @return LoadBalancerSpecClient
     */
    public function loadBalancerSpecs()
    {
        return (new LoadBalancerSpecClient($this->httpClient))->auth($this->token);
    }

    /**
     * @return LoadBalancerClient
     */
    public function loadBalancers()
    {
        return (new LoadBalancerClient($this->httpClient))->auth($this->token);
    }

    /**
     * @return TaskClient
     */
    public function tasks()
    {
        return (new TaskClient($this->httpClient))->auth($this->token);
    }

    /**
     * @return VipClient
     */
    public function vips()
    {
        return (new VipClient($this->httpClient))->auth($this->token);
    }

    /**
     * @return NicClient
     */
    public function nics()
    {
        return (new NicClient($this->httpClient))->auth($this->token);
    }

    /**
     * @return AffinityRuleClient
     */
    public function affinityRules()
    {
        return (new AffinityRuleClient($this->httpClient))->auth($this->token);
    }

    /**
     * @return AffinityRuleMemberClient
     */
    public function affinityRuleMembers()
    {
        return (new AffinityRuleMemberClient($this->httpClient))->auth($this->token);
    }

    /**
     * @return ResourceTierClient
     */
    public function resourceTiers()
    {
        return (new ResourceTierClient($this->httpClient))->auth($this->token);
    }

    /**
     * @return SoftwareClient
     */
    public function software()
    {
        return (new SoftwareClient($this->httpClient))->auth($this->token);
    }

    /**
     * @return VpnGatewaySpecificationClient
     */
    public function vpnGatewaySpecifications()
    {
        return (new VpnGatewaySpecificationClient($this->httpClient))->auth($this->token);
    }

    /**
     * @return VpnGatewayClient
     */
    public function vpnGateways()
    {
        return (new VpnGatewayClient($this->httpClient))->auth($this->token);
    }

    /**
     * @return VpnGatewayUserClient
     */
    public function vpnGatewayUsers()
    {
        return (new VpnGatewayUserClient($this->httpClient))->auth($this->token);
    }

    /**
     * @return BillingHistoryClient
     */
    public function billingHistory()
    {
        return (new BillingHistoryClient($this->httpClient))->auth($this->token);
    }

    /**
     * @return InstanceSoftwareClient
     */
    public function instanceSoftware()
    {
        return (new InstanceSoftwareClient($this->httpClient))->auth($this->token);
    }

    /**
     * @return TagClient
     */
    public function tags()
    {
        return (new TagClient($this->httpClient))->auth($this->token);
    }
}
