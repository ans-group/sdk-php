<?php

namespace UKFast\SDK\DDoSX;

use UKFast\SDK\Client as BaseClient;
use UKFast\SDK\DDoSX\Entities\VerificationFile;

class DomainVerificationClient extends BaseClient
{
    /**
     * @inheritDoc
     */
    protected $basePath = 'ddosx/';

    /**
     * Verify the domain via DNS
     *
     * @param $domainName
     * @return boolean
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function verifyByDns($domainName)
    {
        $response = $this->post('v1/domains/' . $domainName . '/verify/dns');

        return $response->getStatusCode() == 200;
    }

    /**
     * Verify the domain via file upload
     *
     * @param $domainName
     * @return boolean
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function verifyByFile($domainName)
    {
        $response = $this->post('v1/domains/' . $domainName . '/verify/file-upload');

        return $response->getStatusCode() == 200;
    }

    /**
     * Get the file for file upload verification
     *
     * @param $domainName
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getVerificationFile($domainName)
    {
        return new VerificationFile([
            'response' => $this->get('v1/domains/' . $domainName . '/verify/file-upload')
        ]);
    }
}
