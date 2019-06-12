<?php

namespace UKFast\PSS;

use GuzzleHttp\Exception\ClientException;
use UKFast\Exception\ApiException;
use UKFast\Exception\NotFoundException;
use UKFast\Page;
use UKFast\Client as BaseClient;
use DateTime;

class Client extends BaseClient
{
    public function requests()
    {
        return (new RequestClient($this->httpClient));
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
        $page = $this->paginatedRequest("v1/requests/$requestId/conversation", $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return $this->serializeReply($item);
        });

        return $page;
    }

    /**
     * Converts a response stdClass into a Reply object
     *
     * @param $item
     * @return \UKFast\Pss\Reply
     */
    protected function serializeReply($item)
    {
        $reply = new Entities\Reply;
        
        $reply->author = new Entities\Author($item->author);
        $reply->description = $item->description;
        $reply->createdAt = DateTime::createFromFormat(DateTime::ISO8601, $item->created_at);
        
        return $reply;
    }
}
