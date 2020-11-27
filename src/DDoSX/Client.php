<?php

namespace UKFast\SDK\DDoSX;

use UKFast\SDK\Client as BaseClient;

class Client extends BaseClient
{
    /**
     * @inheritDoc
     */
    protected $basePath = 'ddosx/';

    /**
     * Return a DomainClient instance
     *
     * @return DomainClient
     */
    public function domains()
    {
        return (new DomainClient($this->httpClient))->auth($this->token);
    }

    /**
     * Return a CdnClient instance
     *
     * @return CdnClient
     */
    public function cdn()
    {
        return (new CdnClient($this->httpClient))->auth($this->token);
    }

    /**
     * Return a CdnRuleClient instance
     *
     * @return CdnRuleClient
     */
    public function cdnRules()
    {
        return (new CdnRuleClient($this->httpClient))->auth($this->token);
    }

    /**
     * Return a WafClient instance
     *
     * @return WafClient
     */
    public function waf()
    {
        return (new WafClient($this->httpClient))->auth($this->token);
    }

    /**
     * Return a WafRuleClient instance
     *
     * @return WafRuleClient
     */
    public function wafRules()
    {
        return (new WafRuleClient($this->httpClient))->auth($this->token);
    }

    /**
     * Return a WafAdvancedRuleClient instance
     *
     * @return WafAdvancedRuleClient
     */
    public function wafAdvancedRules()
    {
        return (new WafAdvancedRuleClient($this->httpClient))->auth($this->token);
    }

    /**
     * Return a WafRulesetClient instance
     *
     * @return WafRulesetClient
     */
    public function wafRulesets()
    {
        return (new WafRulesetClient($this->httpClient))->auth($this->token);
    }

    /**
     * Return a DomainVerificationClient instance
     *
     * @return DomainVerificationClient
     */
    public function domainVerification()
    {
        return (new DomainVerificationClient($this->httpClient))->auth($this->token);
    }

    /**
     * Return a RecordClient instance
     *
     * @return RecordClient
     */
    public function records()
    {
        return (new RecordClient($this->httpClient))->auth($this->token);
    }

    /**
     * Return a SslClient instance
     *
     * @return SslClient
     */
    public function ssls()
    {
        return (new SslClient($this->httpClient))->auth($this->token);
    }

    /**
     * Return the AclGeoIpClient instance
     * @return AclGeoIpClient
     */
    public function aclGeoIps()
    {
        return (new AclGeoIpClient($this->httpClient))->auth($this->token);
    }

    /**
     * Return the HstsClient instance
     * @return HstsClient
     */
    public function hsts()
    {
        return (new HstsClient($this->httpClient))->auth($this->token);
    }

    /**
     * Return the DomainPropertiesClient instance
     * @return DomainPropertiesClient
     */
    public function domainProperties()
    {
        return (new DomainPropertiesClient($this->httpClient))->auth($this->token);
    }

    /**
     * Return a WafLogClient instance
     *
     * @return WafLogClient
     */
    public function wafLogs()
    {
        return (new WafLogClient($this->httpClient))->auth($this->token);
    }

    /**
     * Return a WafLogMatchClient instance
     *
     * @return WafLogMatchClient
     */
    public function wafLogMatches()
    {
        return (new WafLogMatchClient($this->httpClient))->auth($this->token);
    }

    /**
     * Return a AccessLogClient instance
     *
     * @return AccessLogClient
     */
    public function accessLogs()
    {
        return (new AccessLogClient($this->httpClient))->auth($this->token);
    }
}
