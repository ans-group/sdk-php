<?php

namespace UKFast\SDK\LTaaS;

use UKFast\SDK\LTaaS\Entities\JobResults;
use UKFast\SDK\LTaaS\Entities\JobSettings;
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
     * Get all the jobs
     */
    public function getAll($filters = [])
    {
        // get first page
        $page = $this->getPage($currentPage = 1, $perPage = 100, $filters);
        if ($page->totalItems() == 0) {
            return [];
        }

        $jobs = $page->getItems();
        if ($page->totalPages() == 1) {
            return $jobs;
        }

        // get any remaining pages
        while ($page->pageNumber() < $page->totalPages()) {
            $page = $this->getPage($currentPage++, $perPage, $filters);

            $jobs = array_merge(
                $jobs,
                $page->getItems()
            );
        }

        return $jobs;
    }

    /**
     * Get the settings that are associated with a test
     * @param $id
     * @return JobSettings
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function settings($id)
    {
        $response = $this->get('v1/jobs/' . $id . '/settings');

        $body = $this->decodeJson($response->getBody()->getContents());

        return new JobSettings($body->data);
    }

    /**
     * Get the results that are associated with a test
     * @param $id
     * @return JobResults
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function results($id)
    {
        $response = $this->get('v1/jobs/' . $id . '/results');

        $body = $this->decodeJson($response->getBody()->getContents());

        return new JobResults($body->data);
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
            'domain_id' => $job->domainId,
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
     * Stop a pending or running test
     * @param $id
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function stop($id)
    {
        $response = $this->get('v1/jobs/' . $id . '/stop');

        return $response->getStatusCode() == 200;
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
