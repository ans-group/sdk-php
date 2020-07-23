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
     * Return a wafClient instance
     *
     * @return WafClient
     */
    public function waf()
    {
        return (new WafClient($this->httpClient))->auth($this->token);
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
     * Return the DomainPropertiesClient instance
     * @return DomainPropertiesClient
     */
    public function domainProperties()
    {
        return (new DomainPropertiesClient($this->httpClient))->auth($this->token);
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
}
