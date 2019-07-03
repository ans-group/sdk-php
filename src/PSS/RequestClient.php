<?php

namespace UKFast\SDK\PSS;

use DateTime;
use UKFast\SDK\Client as BaseClient;

class RequestClient extends BaseClient
{
    protected $basePath = 'pss/';

    /**
     * Gets a paginated response of all PSS requests
     *
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return \UKFast\SDK\Page
     */
    public function getPage($page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest('v1/requests', $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return $this->serializeRequest($item);
        });

        return $page;
    }

    /**
     * Gets an individual request
     *
     * @param int $id
     * @return \UKFast\SDK\PSS\Entities\Request
     */
    public function getById($id)
    {
        $response = $this->request("GET", "v1/requests/$id");
        $body = $this->decodeJson($response->getBody()->getContents());
        return $this->serializeRequest($body->data);
    }



    /**
     * Converts a response stdClass into a Request object
     *
     * @param \stdClass
     * @return \UKFast\SDK\Pss\Request
     */
    protected function serializeRequest($item)
    {
        $request = new Entities\Request;

        $request->id = $item->id;
        $request->author = new Entities\Author($item->author);
        $request->type = $item->type;
        $request->secure = $item->secure;
        $request->subject = $item->subject;
        $request->createdAt = DateTime::createFromFormat(DateTime::ISO8601, $item->created_at);
        $request->priority = $item->priority;
        $request->archived = $item->archived;
        $request->status = $item->status;
        $request->requestSms = $item->request_sms;
        $request->customerReference = $item->customer_reference;
        $request->product = new Entities\Product($item->product);
        $request->lastRepliedAt = null;
        if ($item->last_replied_at) {
            $request->lastRepliedAt = DateTime::createFromFormat(DateTime::ISO8601, $item->last_replied_at);
        }

        return $request;
    }
}
