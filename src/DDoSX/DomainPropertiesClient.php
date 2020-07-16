<?php
namespace UKFast\SDK\DDoSX;

use UKFast\SDK\Client as BaseClient;
use UKFast\SDK\DDoSX\Entities\DomainProperty;
use UKFast\SDK\SelfResponse;

class DomainPropertiesClient extends BaseClient
{
    protected $basePath = 'ddosx/';

    const DOMAIN_PROPERTIES_MAP = [];

    /**
     * Update a Domain's property
     * @param $domainId
     * @param $propertyId
     * @param $data
     * @return SelfResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function update($domainId, $propertyId, $data)
    {
        $requestBody = [
            'value' => $data->value
        ];
        $response = $this->patch('v1/domains/' . $domainId . '/properties/' . $propertyId, $requestBody);
        $response = $this->decodeJson($response->getBody()->getContents());

        return (new SelfResponse($response))
            ->setClient($this)
            ->serializeWith(function ($response) {
                return $this->serializeData($response->data);
            });
    }

    /**
     * @param $raw
     * @return DomainProperty
     */
    public function serializeData($raw)
    {
        return new DomainProperty($this->apiToFriendly($raw, self::DOMAIN_PROPERTIES_MAP));
    }
}
