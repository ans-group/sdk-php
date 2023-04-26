<?php

namespace UKFast\SDK\SSL;

use UKFast\SDK\Client as BaseClient;
use UKFast\SDK\SSL\Entities\DcvValidation;
use UKFast\SDK\SSL\Entities\ValidationResult;

class DcvClient extends BaseClient
{
    protected $basePath = 'ssl/';

    /**
     * Validation Result API fields which need to be mapped
     *
     * @var array
     */
    public $validationMap = [];

    /**
     * Validate a certificate against its key and CA DCV type
     *
     * @param string $key
     * @param string $certificate
     * @param string|null $caBundle
     * @return DcvValidation
     */
    public function validate($certificateId, $dcvType)
    {
        $requestBody = [
            'dcv_type' => $dcvType,
        ];

        $url = 'v1/dcv/' . urlencode($certificateId) . '/validate';
        $this->post($url, json_encode($requestBody));

        return new DcvValidation($this->apiToFriendly([], $this->validationMap));
    }
}
