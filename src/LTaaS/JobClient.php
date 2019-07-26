<?php

namespace UKFast\SDK\LTaaS;

use UKFast\SDK\LTaaS\Entities\JobSettings;
use UKFast\SDK\Page;
use UKFast\SDK\LTaaS\Entities\Job;

class JobClient extends Client
{
    protected $basePath = 'ltaas/';

    /**
     * Gets paginated response for all of the domains
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return int|Page
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getPage($page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest('v1/jobs', $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return new Job($item);
        });

        return $page;
    }

    /**
     * Get the settings that are associated with a test
     * @param $id
     * @return JobSettings
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getSettings($id)
    {
        $response = $this->get('v1/jobs/' . $id .  '/settings');

        $body = $this->decodeJson($response->getBody()->getContents());

        return new JobSettings($body->data);
    }

    /**
     * Soft delete a job
     * @param $id
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function destroy($id)
    {
        $response = $this->delete('v1/jobs/' . $id);

        return $response->getStatusCode() == 204;
    }
}
