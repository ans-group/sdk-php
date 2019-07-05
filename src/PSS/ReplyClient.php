<?php

namespace UKFast\SDK\PSS;

use UKFast\SDK\Client as BaseClient;
use DateTime;

class ReplyClient extends BaseClient
{
    /**
     * Gets a paginated response of all replies to a ticket
     *
     * @param int $requestId - ID of request replies belong to
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return \UKFast\SDK\Page
     */
    public function getPage($requestId, $page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest("v1/requests/$requestId/replies", $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return $this->serializeReply($item);
        });

        return $page;
    }

    /**
     * Converts a response stdClass into a Reply object
     *
     * @param $item
     * @return \UKFast\SDK\PSS\Entities\Reply
     */
    protected function serializeReply($item)
    {
        $reply = new Entities\Reply;
        
        $reply->author = new Entities\Author($item->author);
        $reply->description = $item->description;
        $reply->createdAt = DateTime::createFromFormat(DateTime::ISO8601, $item->created_at);

        foreach ($item->attachments as $attachment) {
            $reply->attachments[] = new Entities\Attachment($attachment);
        }

        return $reply;
    }
}
