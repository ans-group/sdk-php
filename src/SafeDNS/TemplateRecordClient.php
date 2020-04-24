<?php
/**
 * @author: John Birch-Evans <john.birch-evans@ukfast.co.uk>
 * @copyright: 2020 UKFast.net Ltd
 */

namespace UKFast\SDK\SafeDNS;

use UKFast\SDK\Client;
use UKFast\SDK\SafeDNS\Entities\Record;

class TemplateRecordClient extends Client
{
    const RECORD_MAP = [
        'created_at' => 'createdAt'
    ];

    /**
     * Gets a paginated list of records for a template
     * @param $id
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return int|\UKFast\SDK\Page
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getPage($id, $page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest('v1/templates/' . $id . '/records', $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return $this->serializeData($item);
        });

        return $page;
    }

    /**
     * Gets a specific record for a template
     * @param $templateId
     * @param $recordId
     * @return Record
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getById($templateId, $recordId)
    {
        $response = $this->get('v1/templates/' . $templateId . '/records/' . $recordId);
        $body = $this->decodeJson($response->getBody()->getContents());

        return $this->serializeData($body->data);
    }

    protected function serializeData($raw)
    {
        return new Record($this->apiToFriendly($raw, self::RECORD_MAP));
    }
}
