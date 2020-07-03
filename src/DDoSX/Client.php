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
     * Return a domainClient instance
     *
     * @return DomainClient
     */
    public function domains()
    {
        return (new DomainClient($this->httpClient))->auth($this->token);
    }

    /**
     * Return a cdnClient instance
     *
     * @return CdnClient
     */
    public function cdn()
    {
        return (new CdnClient($this->httpClient))->auth($this->token);
    }

    /**
     * Return a cdnClient instance
     *
     * @return CdnRuleClient
     */
    public function cdnRules()
    {
        return (new CdnRuleClient($this->httpClient))->auth($this->token);
    }

    /**
     * Return a wafClient instance
     *
     * @return WafClient
     */
    public function waf()
    {
        return (new WafClient($this->httpClient))->auth($this->token);
    }

    /**
     * Return a wafRuleClient instance
     *
     * @return WafRuleClient
     */
    public function wafRules()
    {
        return (new WafRuleClient($this->httpClient))->auth($this->token);
    }

    /**
     * Return a wafRuleClient instance
     *
     * @return WafAdvancedRuleClient
     */
    public function wafAdvancedRules()
    {
        return (new WafAdvancedRuleClient($this->httpClient))->auth($this->token);
    }

    /**
     * Return a wafRuleClient instance
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
     * Return the HstsRulesClient instance
     * @return HstsRuleClient
     */
    public function hstsRules()
    {
        return (new HstsRuleClient($this->httpClient))->auth($this->token);
    }
}
