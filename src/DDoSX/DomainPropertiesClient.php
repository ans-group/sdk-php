<?php
namespace UKFast\SDK\DDoSX;

use UKFast\SDK\Client as BaseClient;
use UKFast\SDK\DDoSX\Entities\DomainProperty;

class DomainPropertiesClient extends BaseClient
{
    protected $basePath = 'ddosx/';
    const MAP = [];

    /**
     * Get a paginated list of domain properties
     * @param $domainName
     * @param int $page
     * @param int $perPage
     * @param array $filter
     * @return int|\UKFast\SDK\Page
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getPage($domainName, $page = 1, $perPage = 15, $filter = [])
    {
        $response = $this->paginatedRequest('v1/domains/' . $domainName . '/properties', $page, $perPage);

        $page = $response->serializeWith(function ($item) {
            return $this->serializeData($item);
        });

        return $page;
    }

    /**
     * Get a property by it's ID
     * @param $domainId
     * @param $propertyId
     * @return DomainProperty
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getById($domainId, $propertyId)
    {
        $response = $this->get('v1/domains/' . $domainId . '/properties/' . $propertyId);
        $body = $this->decodeJson($response->getBody()->getContents());
        return $this->serializeData($body->data);
    }

    /**
     * @return DomainProperty
     */
    public function serializeData($raw)
    {
        return new DomainProperty($this->apiToFriendly($raw, self::MAP));
    }
}
