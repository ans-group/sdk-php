<?php

namespace UKFast\SDK\eCloud;

use UKFast\SDK\eCloud\Entities\GpuProfile;
use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\Page;

use UKFast\SDK\eCloud\Entities\Appliance;
use UKFast\SDK\eCloud\Entities\Pod;
use UKFast\SDK\eCloud\Entities\Template;

class PodClient extends Client implements ClientEntityInterface
{
    const MAP = [
        'id' => 'id',
        'name' => 'name',
        'services' => 'services'
    ];

    const GPU_PROFILE_MAP = [
        'card_type' => 'cardType'
    ];

    /**
     * Gets a paginated response of Pods
     *
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return Page
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getPage($page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest("v1/pods", $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return $this->loadEntity($item);
        });

        return $page;
    }

    /**
     * Gets an individual Pod
     *
     * @param int $id
     * @return Pod
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getById($id)
    {
        $response = $this->get('v1/pods/' . $id);
        return $this->loadEntity($this->decodeJson($response->getBody()->getContents())->data);
    }

    /**
     * Gets a paginated response of a Pods Templates
     *
     * @param $id
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return Page
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getTemplates($id, $page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest("v1/pods/$id/templates", $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return new Template($item);
        });

        return $page;
    }

    /**
     * Gets an individual Pod Template
     *
     * @param int $id
     * @param $name
     * @return Template
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getTemplateByName($id, $name)
    {
        $response = $this->get("v1/pods/$id/templates/$name");
        $body = $this->decodeJson($response->getBody()->getContents());
        return new Template($body->data);
    }

    /**
     * Gets a paginated response of a Pods Appliances
     *
     * @param $id
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return Page
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getAppliances($id, $page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest("v1/pods/$id/appliances", $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return new Appliance($this->apiToFriendly($item, ApplianceClient::MAP));
        });

        return $page;
    }

    /**
     * Get a paginated results of pod GPUs
     * @param $id
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return int|Page
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getGpuProfiles($id, $page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest('v1/pods/' . $id . '/gpu-profiles', $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return new GpuProfile($this->apiToFriendly($item, self::GPU_PROFILE_MAP));
        });

        return $page;
    }

    /**
     * Load Pod Entity
     * @param $data
     * @return mixed|Pod
     */
    public function loadEntity($data)
    {
        return new Pod($this->apiToFriendly($data, static::MAP));
    }
}
