<?php

namespace UKFast\SDK\SSL;

use UKFast\SDK\Client as BaseClient;
use UKFast\SDK\Exception\ApiException;
use UKFast\SDK\SSL\Entities\Certificate;

class DcvClient extends BaseClient
{
    protected $basePath = 'ssl/';

    /**
     * Validates a certificate against dcv type
     *
     * @param Certificate $certificate
     * @return true
     * @throws ApiException
     */
    public function validate(Certificate $certificate)
    {
        $body = null;
        $hostnames = [];

        if (empty($certificate->commonName) === false) {
            $hostnames[] = $certificate->commonName;
        }

        if (is_array($certificate->alternativeNames) && empty($certificate->alternativeNames) === false) {
            $hostnames[] = array_merge($hostnames, $certificate->alternativeNames);
        }

        if (empty($hostnames) === false) {
            $body = json_encode([
                'hostnames' => $hostnames,
            ]);
        }

        $this->post('v1/dcv/' . urlencode($certificate->id) . '/validate', $body);

        return true;
    }
}
