<?php

namespace UKFast\SDK\PSS;

use DateTime;
use UKFast\SDK\SelfResponse;
use UKFast\SDK\Client as BaseClient;

class RequestClient extends BaseClient
{
    protected $basePath = 'pss/';

    protected $requestMap = [
        'created_at' => 'createdAt',
        'request_sms' => 'requestSms',
        'customer_reference' => 'customerReference',
        'last_replied_at' => 'lastRepliedAt',
        'system_reference' => 'systemReference',
        'unread_replies' => 'unreadReplies',
        'contact_method' => 'contactMethod',
    ];

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
        $filters = $this->friendlyToApi($filters, $this->requestMap);

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
     * @param $request
     * @return SelfResponse
     */
    public function create($request)
    {
        $response = $this->post("v1/requests", $this->requestToJson($request));
        $response = $this->decodeJson($response->getBody()->getContents());

        return (new SelfResponse($response))
            ->setClient($this)
            ->serializeWith(function ($response) {
                return $this->serializeRequest($response->data);
            });
    }

    /**
     * @param int $id
     * @param \UKFast\SDK\PSS\Entities\Request $request
     */
    public function update($id, $request)
    {
        $response = $this->patch("v1/requests/$id", $this->requestToJson($request));
        $response = $this->decodeJson($response->getBody()->getContents());

        return (new SelfResponse($response))
            ->setClient($this)
            ->serializeWith(function ($response) {
                return $this->serializeRequest($response->data);
            });
    }

    /**
     * @var int $ticketId
     * @var \UKFast\SDK\PSS\Entities\Feedback $feedback
     * @throws \UKFast\SDK\Exception\ApiException
     * @return \UKFast\SDK\SelfResponse
     */
    public function leaveFeedback($ticketId, $feedback)
    {
        $response = $this->post("v1/requests/$ticketId/feedback", json_encode([
            'speed_resolved' => $feedback->speedResolved,
            'comment' => $feedback->comment,
            'contact_id' => $feedback->contactId,
            'quality' => $feedback->quality,
            'score' => $feedback->score,
            'nps_score' => $feedback->npsScore,
            'thirdparty_consent' => $feedback->thirdPartyConsent,
        ]));

        $response = $this->decodeJson($response->getBody()->getContents());

        return (new SelfResponse($response))
            ->setClient($this)
            ->serializeWith(function ($response) {
                return $this->serializeFeedback($response->data);
            });
    }

    /**
     * @param $requestId
     * @return SelfResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function markAsRead($requestId)
    {
        $response = $this->patch("v1/requests/$requestId", json_encode([
            'read' => true,
        ]));
        $response = $this->decodeJson($response->getBody()->getContents());

        return (new SelfResponse($response))
            ->setClient($this)
            ->serializeWith(function ($response) {
                return $this->serializeRequest($response->data);
            });
    }

    /**
     * @throws \UKFast\SDK\Exception\ApiException
     * @return \UKFast\SDK\PSS\Entities\Feedback
     */
    public function getFeedback($id)
    {
        $response = $this->request("GET", "v1/requests/$id/feedback");
        $body = $this->decodeJson($response->getBody()->getContents());
        return $this->serializeFeedback($body->data);
    }

    /**
     * Converts a response stdClass into a Request object
     *
     * @param \stdClass
     * @return \UKFast\SDK\Pss\Request
     */
    protected function serializeRequest($item)
    {
        $request = new Entities\Request($this->apiToFriendly($item, $this->requestMap));
        $request->author = new Entities\Author($item);
        $request->product = new Entities\Product($item);

        return $request;
    }

    public function serializeFeedback($item)
    {
        $feedback = new Entities\Feedback;

        $feedback->id = $item->id;
        $feedback->comment = $item->comment;
        $feedback->speedResolved = $item->speed_resolved;
        $feedback->quality = $item->quality;
        $feedback->score = $item->score;
        $feedback->npsScore = $item->nps_score;
        $feedback->thirdPartyConsent = $item->thirdparty_consent;

        return $feedback;
    }

    protected function requestToJson($request)
    {
        $json = $this->friendlyToApi($request, $this->requestMap);

        if ($request->author) {
            $json['author'] = $request->author->toArray();
        }

        if ($request->product) {
            $json['product'] = $request->product->toArray();
        }
        
        return json_encode($json);
    }
}
