<?php

namespace UKFast;

use GuzzleHttp\Exception\ClientException;
use UKFast\Exception\ApiException;
use UKFast\Exception\NotFoundException;
use UKFast\Pss\Author;
use UKFast\Pss\Reply;
use UKFast\Pss\Request;
use DateTime;

class PssClient extends Client
{
    protected $basePath = 'pss/v1/';

    /**
     * Gets a paginated response of all PSS requests
     *
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return \UKFast\Page
     */
    public function getRequests($page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest('requests', $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return $this->serializeRequest($item);
        });

        return $page;
    }

    /**
     * Gets an individual request
     *
     * @param int $id
     * @return \UKFast\Pss\Request
     */
    public function getRequest($id)
    {
        $response = $this->request("GET", "requests/$id");
        $body = $this->decodeJson($response->getBody()->getContents());
        return $this->serializeRequest($body->data);
    }

    /**
     * Gets a paginated response of all conversation replies to a ticket
     *
     * @param int $requestId - ID of request replies belong to
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return \UKFast\Page
     */
    public function getConversation($requestId, $page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest("requests/$requestId/conversation", $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return $this->serializeReply($item);
        });

        return $page;
    }

    /**
     * Converts a response stdClass into a Request object
     *
     * @param \stdClass
     * @return \UKFast\Pss\Request
     */
    protected function serializeRequest($item)
    {
        $request = new Request;

        $request->id = $item->id;
        $request->author = new Author($item->author);
        $request->type = $item->type;
        $request->secure = $item->secure;
        $request->subject = $item->subject;
        $request->createdAt = $item->created_at;
        $request->priority = $item->priority;
        $request->archived = $item->archived;
        $request->status = $item->status;
        $request->requestSms = $item->request_sms;

        return $request;
    }

    /**
     *
     */
    protected function serializeReply($item)
    {
        $reply = new Reply;
        
        $reply->author = new Author($item->author);
        $reply->description = $item->description;
        $reply->createdAt = DateTime::createFromFormat(DateTime::ISO8601, $item->created_at);
        
        return $reply;
    }
}
