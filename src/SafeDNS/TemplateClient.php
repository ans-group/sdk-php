<?php

namespace UKFast\SDK\SafeDNS;

use UKFast\SDK\SafeDNS\Entities\Record;
use UKFast\SDK\SafeDNS\Entities\Template;

class TemplateClient extends Client
{
    const TEMPLATE_MAP = [
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
    public function getPage($page = 1, $perPage = 20, $filters = [])
    {
        $page = $this->paginatedRequest('v1/templates', $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return $this->serializeData($item);
        });

        return $page;
    }

    /**
     * Gets a specific template by id
     * @param $id
     * @return Template
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getById($id)
    {
        $response = $this->get('v1/templates/' . $id);
        $body = $this->decodeJson($response->getBody()->getContents());

        return $this->serializeData($body->data);
    }

    /**
     * Convert the api fields to a friendly name
     * @param $raw
     * @return Template
     */
    protected function serializeData($raw)
    {
        return new Template($this->apiToFriendly($raw, self::TEMPLATE_MAP));
    }
}
