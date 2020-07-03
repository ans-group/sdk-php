<?php

namespace UKFast\SDK\LTaaS;

use UKFast\SDK\LTaaS\Entities\TestAuthorisation;
use UKFast\SDK\Page;
use UKFast\SDK\LTaaS\Entities\Test;
use UKFast\SDK\SelfResponse;

class TestClient extends Client
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
        $page = $this->paginatedRequest('v1/tests', $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return new Test($item);
        });

        return $page;
    }

    /**
     * Get all the tests
     */
    public function getAll($filters = [])
    {
        // get first page
        $page = $this->getPage($currentPage = 1, $perPage = 100, $filters);
        if ($page->totalItems() == 0) {
            return [];
        }

        $tests = $page->getItems();
        if ($page->totalPages() == 1) {
            return $tests;
        }

        // get any remaining pages
        while ($page->pageNumber() < $page->totalPages()) {
            $page = $this->getPage($currentPage++, $perPage, $filters);

            $tests = array_merge(
                $tests,
                $page->getItems()
            );
        }

        return $tests;
    }

    /**
     * Get a test by it's ID
     * @param $id
     * @return Test
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getById($id)
    {
        $response = $this->get('v1/tests/' . $id);
        $body = $this->decodeJson($response->getBody()->getContents());

        return new Test($body->data);
    }

    /**
     * Send the request to the API to store a new test
     * @param Test $test
     * @param TestAuthorisation $authorisation
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function create(Test $test, TestAuthorisation $authorisation)
    {
        $data = [
            'name' => $test->name,
            'scenario_id' => $test->scenarioId,
            'domain_id' => $test->domainId,
            'protocol' => $test->protocol,
            'path' => $test->path,
            'number_of_users' => $test->numberUsers,
            'duration' => $test->duration,
            'recurring_type' => $test->recurringType,
            'recurring_value' => $test->recurringValue,
            'section_users' => (isset($test->sectionUsers)) ? $test->sectionUsers : null,
            'section_time' => (isset($test->sectionTime)) ? $test->sectionTime : null,
            'next_run' => $test->nextRun,
            'thresholds' => (isset($test->thresholds)) ? $test->thresholds : null,
            'authorisation' => [
                'agreement_version' => $authorisation->agreementVersion,
                'name' => $authorisation->name,
                'position' => $authorisation->position,
                'company' => $authorisation->company
            ]
        ];

        $response = $this->post('v1/tests', json_encode($data));

        $body = $this->decodeJson($response->getBody()->getContents());

        return (new SelfResponse($body))
            ->setClient($this)
            ->serializeWith(function ($body) {
                return $this->serializeRequest($body->data);
            });
    }

    /**
     * Soft delete a test
     * @param $id
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function destroy($id)
    {
        $response = $this->delete('v1/tests/' . $id);

        return $response->getStatusCode() == 204;
    }
}
