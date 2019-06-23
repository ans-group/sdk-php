<?php

namespace UKFast\eCloud;

use UKFast\Page;

use UKFast\eCloud\Entities\Pod;
use UKFast\eCloud\Entities\Template;

class PodClient extends Client
{
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
            return new Pod($item);
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
        $response = $this->get("v1/pods/$id");
        $body = $this->decodeJson($response->getBody()->getContents());
        return new Pod($body->data);
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
}
