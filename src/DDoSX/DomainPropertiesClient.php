<?php
namespace UKFast\SDK\DDoSX;

use UKFast\SDK\Client as BaseClient;
use UKFast\SDK\DDoSX\Entities\DomainProperty;
use UKFast\SDK\SelfResponse;

class DomainPropertiesClient extends BaseClient
{
    protected $basePath = 'ddosx/';

    const MAP = [];

    /**
     * Update a domain's property
     * @param $domainId
     * @param $propertyId
     * @param $data
     * @return SelfResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function update($domainId, $propertyId, $data)
    {
        $payload = [
            'value' => $data->value
        ];
        $response = $this->patch('v1/domains/' . $domainId . '/properties/' . $propertyId, $payload);
        $response = $this->decodeJson($response->getBody()->getContents());
        return (new SelfResponse($response))
            ->setClient($this)
            ->serializeWith(function ($response) {
                return $this->serializeData($response->data);
            });
    }

    /**
     * @return DomainProperty
     */
    public function serializeData($raw)
    {
        return new DomainProperty($this->apiToFriendly($raw, self::MAP));
    }
}
