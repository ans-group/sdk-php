<?php

namespace UKFast\SDK\eCloud;

use UKFast\SDK\eCloud\Entities\Appliance\Version\Data;
use UKFast\SDK\Page;

class ApplianceVersionClient extends Client
{
    const MAP = [
        'id' => 'id',
        'appliance_id' => 'applianceId',
        'version' => 'version',
        'script_template' => 'scriptTemplate',
        'vm_template' => 'vmTemplate',
        'active' => 'active',
        'created_at' => 'createdAt',
        'updated_at' => 'updatedAt',
    ];

    /**
     * Gets a paginated response of Data
     *
     * @param string $applianceVersionUuid
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return Page
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getDataPage($applianceVersionUuid, $page = 1, $perPage = 15, $filters = [])
    {
        $filters = $this->friendlyToApi($filters, self::MAP);
        $page = $this->paginatedRequest(
            'v1/appliance-version/' . $applianceVersionUuid . '/data',
            $page,
            $perPage,
            $filters
        );
        $page->serializeWith(function ($item) {
            return new Data($item);
        });
        return $page;
    }

    /**
     * Gets individual Data
     *
     * @param string $applianceVersionUuid
     * @param string $key
     * @return Data
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getDataByKey($applianceVersionUuid, $key)
    {
        $response = $this->get('v1/appliance-version/' . $applianceVersionUuid . '/data/' . $key);
        $body = $this->decodeJson($response->getBody()->getContents());
        return new Data($body->data);
    }
}
