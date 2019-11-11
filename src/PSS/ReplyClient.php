<?php

namespace UKFast\SDK\PSS;

use DateTime;
use UKFast\SDK\Client as BaseClient;
use UKFast\SDK\PSS\Entities\Download;
use UKFast\SDK\SelfResponse;

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
     * Gets an individual reply
     *
     * @param int $id
     * @return \UKFast\SDK\PSS\Entities\Reply
     */
    public function getById($id)
    {
        $response = $this->request("GET", "v1/replies/$id");
        $body = $this->decodeJson($response->getBody()->getContents());
        return $this->serializeReply($body->data);
    }

    /**
     * @param int $requestId
     * @param \UKFast\SDK\PSS\Entities\Reply $reply
     * @return SelfResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function create($requestId, $reply)
    {
        $payload = json_encode([
            'author' => [
              'id' => $reply->author->id,
            ],
            'description' => $reply->description,
        ]);

        $response = $this->post("v1/requests/{$requestId}/replies", $payload);
        $response = $this->decodeJson($response->getBody()->getContents());

        return (new SelfResponse($response))
            ->setClient($this)
            ->serializeWith(function ($response) {
                return $this->serializeReply($response->data);
            });
    }

    /**
     * Uploads an attachment to a reply
     *
     * @param int $replyId
     * @param string $name
     * @param string $content
     */
    public function upload($replyId, $name, $content)
    {
        $name = urlencode($name);
        $uri = "v1/replies/$replyId/attachments/$name";
        $response = $this->request('POST', $uri, $content);

        $json = $this->decodeJson($response->getBody()->getContents());

        return (new AttachmentSelfResponse($json))
            ->setClient($this);
    }

    /**
     * Downloads an attachment
     *
     * @return \GuzzleHttp\Psr7\Stream
     */
    public function download($replyId, $name)
    {
        return new Download(
            $this->request('GET', "v1/replies/$replyId/attachments/$name")
        );
    }

    /**
     * @param $replyId
     * @param $name
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function deleteAttachment($replyId, $name)
    {
        $this->delete("v1/replies/$replyId/attachments/$name");
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
        
        $reply->id = $item->id;
        $reply->author = new Entities\Author($item->author);
        $reply->description = $item->description;
        $reply->createdAt = DateTime::createFromFormat(DateTime::ISO8601, $item->created_at);
        $reply->read = $item->read;

        foreach ($item->attachments as $attachment) {
            $reply->attachments[] = new Entities\Attachment($attachment);
        }

        return $reply;
    }
}
