<?php

namespace UKFast\SDK\eCloud;

use UKFast\SDK\eCloud\Entities\Appliance;
use UKFast\SDK\eCloud\Entities\ApplianceVersion;
use UKFast\SDK\eCloud\Entities\Appliance\Version\Data;
use UKFast\SDK\Page;

class ApplianceClient extends Client
{
    const MAP = [
        'id' => 'id',
        'name' => 'name',
        'logo_uri' => 'logoUri',
        'description' => 'description',
        'documentation_uri' => 'documentationUri',
        'publisher' => 'publisher',
        'created_at' => 'createdAt',
    ];

    /**
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return Page
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getPage($page = 1, $perPage = 15, $filters = [])
    {
        $filters = $this->friendlyToApi($filters, self::MAP);
        $page = $this->paginatedRequest('v1/appliances', $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return new Appliance($this->apiToFriendly($item, ApplianceClient::MAP));
        });
        return $page;
    }

    /**
     * @param int $id
     * @return Appliance
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getById($id)
    {
        $response = $this->get('v1/appliances/' . $id);
        return new Appliance($this->apiToFriendly(
            $this->decodeJson($response->getBody()->getContents())->data,
            ApplianceClient::MAP
        ));
    }

    /**
     * @param int $id
     * @return ApplianceVersion
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getVersion($id)
    {
        $response = $this->get('v1/appliances/' . $id . '/version');
        return new ApplianceVersion($this->apiToFriendly(
            $this->decodeJson($response->getBody()->getContents())->data,
            ApplianceVersionClient::MAP
        ));
    }

    /**
     * @param int $id
     * @return Data
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getData($id)
    {
        $response = $this->get('v1/appliances/' . $id . '/data');
        return new Data($this->apiToFriendly(
            $this->decodeJson($response->getBody()->getContents())->data,
            DataClient::MAP
        ));
    }
}
