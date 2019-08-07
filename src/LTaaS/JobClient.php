<?php

namespace UKFast\SDK\LTaaS;

use UKFast\SDK\Page;
use UKFast\SDK\LTaaS\Entities\Job;
use UKFast\SDK\SelfResponse;

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
     * Send the request to the API to store a new job
     * @param Job $job
     * @return mixed
     * @throws GuzzleException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function create(Job $job)
    {
        $data = [
            'test_id' => $job->testId,
            'scheduled_timestamp' => $job->scheduledTimestamp,
            'run_now' => $job->runNow
        ];

        $response = $this->post('v1/jobs', json_encode($data));

        $body = $this->decodeJson($response->getBody()->getContents());

        return (new SelfResponse($body))
            ->setClient($this)
            ->serializeWith(function ($body) {
                return $this->serializeRequest($body->data);
            });
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
