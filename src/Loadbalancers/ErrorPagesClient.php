<?php

namespace UKFast\SDK\Loadbalancers;

use UKFast\SDK\Client;
use UKFast\SDK\Loadbalancers\Entities\ErrorPage;
use UKFast\SDK\SelfResponse;

class ErrorPagesClient extends Client
{
    /**
     * Gets a paginated response of all error pages
     *
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return \UKFast\SDK\Page
     */
    public function getPage($page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest('v2/error-pages', $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return $this->serializeErrorPage($item);
        });
        return $page;
    }

    /**
     * Gets an individual error page
     *
     * @param int $id
     * @return \UKFast\SDK\Loadbalancers\Entities\ErrorPage
     */
    public function getById($id)
    {
        $response = $this->request("GET", "v2/error-pages/$id");
        $body = $this->decodeJson($response->getBody()->getContents());
        return $this->serializeErrorPage($body->data);
    }

    /**
     * Creates an error page
     * @param \UKFast\SDK\Loadbalancers\Entities\ErrorPage $errorPage
     * @return \UKFast\SDK\SelfResponse
     */ 
    public function create($errorPage)
    {
        $response = $this->post('v2/error-pages', json_encode($errorPage->toArray([
            'statusCode' => 'status_code',
        ])));

        $response  = $this->decodeJson($response->getBody()->getContents());
        return (new SelfResponse($response))
            ->setClient($this)
            ->serializeWith(function ($response) {
                return $this->serializeErrorPage($response->data);
            });
    }

    /**
     * @param object
     * @return \UKFast\SDK\Loadbalancers\Entities\ErrorPage
     */
    protected function serializeErrorPage($raw)
    {
        return new ErrorPage([
            'id' => $raw->id,
            'statusCode' => $raw->status_code,
            'content' => $raw->content,
        ]);
    }
}
