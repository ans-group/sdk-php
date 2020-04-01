<?php

namespace UKFast\SDK\SafeDNS;

use UKFast\SDK\SafeDNS\Entities\Record;
use UKFast\SDK\SafeDNS\Entities\Template;

class TemplateClient extends Client
{
    const TEMPLATE_MAP = [
        'created_at' => 'createdAt'
    ];

    const RECORD_MAP = [
        'created_at' => 'createdAt'
    ];

    /**
     * Returns a paginated list of available templates
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return int|\UKFast\SDK\Page
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getPage($page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest('v1/templates', $page, $perPage);
        $page->serializeWith(function ($item) {
            return $this->serializeTemplate($item);
        });

        return $page;
    }

    /**
     * Gets a specific template by id
     * @param $id
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getById($id)
    {
        $response = $this->get('v1/templates/' . $id);
        $body = $this->decodeJson($response->getBody()->getContents());

        return $this->serializeTemplate($body->data);
    }

    /**
     * Gets a paginated list of records for the template
     * @param $id
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return int|\UKFast\SDK\Page
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getRecords($id, $page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest('v1/templates/' . $id . '/records', $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
                return $this->serializeRecords($item);
        });

        return $page;
    }

    /**
     * Gets a specific record for a template
     * @param $templateId
     * @param $recordId
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getRecordById($templateId, $recordId)
    {
        $response = $this->get('v1/templates/' . $templateId . '/records/' . $recordId);
        $body = $this->decodeJson($response->getBody()->getContents());

        return $this->serializeRecords($body->data);
    }

    protected function serializeTemplate($raw)
    {
        return new Template($this->apiToFriendly($raw, self::TEMPLATE_MAP));
    }

    protected function serializeRecords($raw)
    {
        return new Record($this->apiToFriendly($raw, self::RECORD_MAP));
    }
}
