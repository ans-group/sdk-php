<?php

namespace UKFast\SDK\DDoSX;

use UKFast\SDK\Client as BaseClient;
use UKFast\SDK\DDoSX\Entities\Record;

class RecordClient extends BaseClient
{
    /**
     * @var string $basePath
     */
    protected $basePath = 'ddosx/';

    /**
     * @var array $requestMap
     */
    protected $requestMap = [
        "domain_name" => "domainName",
        "safedns_record_id" => "safednsRecordId",
        "ssl_id" => "sslId"
    ];

    /**
     * Get paginated response of records
     *
     * @param int   $page
     * @param int   $perPage
     * @param array $filters
     * @return int|\UKFast\SDK\Page
     */
    public function getPage($page = 1, $perPage = 20, $filters = [])
    {
        $filters = $this->friendlyToApi($filters, $this->requestMap);
        $page = $this->paginatedRequest('v1/records', $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return new Record($this->apiToFriendly($item, $this->requestMap));
        });

        return $page;
    }

    /**
     * Get singular records by its Id
     *
     * @param $domainName
     * @param $recordId
     * @return Record
     */
    public function getById($domainName, $recordId)
    {
        $response = $this->request("GET", 'v1/domains/' . $domainName . '/records/' . $recordId);
        $body = $this->decodeJson($response->getBody()->getContents());

        return new Record($this->apiToFriendly($body, $this->requestMap));
    }

    /**
     * Delete a record
     *
     * @param Record $record
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function destroy(Record $record)
    {
        $response = $this->delete("v1/domains/".$record->domain_name."/records/".$record->id);

        return $response->getStatusCode() == 204;
    }
  
    /**
     * Get paginated response of records associated with a domain name
     *
     * @param $domainName
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return int|\UKFast\SDK\Page
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getPageByDomainName($domainName, $page = 1, $perPage = 20, $filters = [])
    {
        $filters = $this->friendlyToApi($filters, $this->requestMap);

        $page = $this->paginatedRequest('v1/domains/' . $domainName . '/records', $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return new Record($this->apiToFriendly($item, $this->requestMap));
        });

        return $page;
    }
}
