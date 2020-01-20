<?php

namespace UKFast\SDK\DDoSX;

use UKFast\SDK\Client as BaseClient;
use UKFast\SDK\DDoSX\Entities\Record;

class RecordClient extends BaseClient
{
    protected $basePath = 'ddosx/';

    /**
     * @param $domainName
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return int|\UKFast\SDK\Page
     */
    public function getPage($domainName, $page = 1, $perPage = 20, $filters = [])
    {
        $page = $this->paginatedRequest('v1/domains/' . $domainName . '/records', $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return new Record($item);
        });

        return $page;
    }

    /**
     * @param $domainName
     * @param $recordId
     * @return UKFast\SDK\DDoSX\Entities\Record
     */
    public function getById($domainName, $recordId)
    {
        $response = $this->request("GET", 'v1/domains/' . $domainName . '/records/' . $recordId);
        $body = $this->decodeJson($response->getBody()->getContents());

        return new Record($body->data);
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
}
