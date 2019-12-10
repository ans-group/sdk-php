<?php

namespace UKFast\SDK\Billing;

use UKFast\SDK\Billing\Entities\PaymentCard;
use UKFast\SDK\Client as BaseClient;
use UKFast\SDK\Page;
use UKFast\SDK\SelfResponse;

class PaymentCardClient extends BaseClient
{
    const MAP = [
        'friendly_name' => 'friendlyName',
        'card_number' => 'cardNumber',
        'card_type' => 'cardType',
        'valid_from' => 'validFrom',
        'issue_number' => 'issueNumber',
        'primary_card' => 'primaryCard',
    ];

    protected $basePath = 'billing/';

    /**
     * Gets a paginated response of all payment cards
     *
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return Page
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getPage($page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest('v1/cards', $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return $this->serializePaymentCard($item);
        });

        return $page;
    }

    /**
     * Gets an individual payment card
     *
     * @param $id
     * @return PaymentCard
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getById($id)
    {
        $response = $this->request("GET", "v1/cards/$id");
        $body = $this->decodeJson($response->getBody()->getContents());
        $item = $body->data;

        return $this->serializePaymentCard($item);
    }

    /**
     * @param $paymentCard
     * @return SelfResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function create($paymentCard)
    {
        $response = $this->post("v1/cards", $this->friendlyToApi($paymentCard, self::MAP));
        $response = $this->decodeJson($response->getBody()->getContents());

        return (new SelfResponse($response))
            ->setClient($this)
            ->serializeWith(function ($response) {
                return $this->serializePaymentCard($response->data);
            });
    }

    /**
     * @param $id
     * @param $paymentCard
     * @return SelfResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function update($id, $paymentCard)
    {
        $response = $this->patch("v1/cards/$id", $this->friendlyToApi($paymentCard, self::MAP));
        $response = $this->decodeJson($response->getBody()->getContents());

        return (new SelfResponse($response))
            ->setClient($this)
            ->serializeWith(function ($response) {
                return $this->serializePaymentCard($response->data);
            });
    }

    /**
     * @param $id
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function destroy($id)
    {
        $this->delete("v1/cards/$id");
    }

    /**
     * @param $item
     * @return PaymentCard
     */
    protected function serializePaymentCard($item)
    {
        $paymentCard = new PaymentCard($this->apiToFriendly($item, self::MAP));

        return $paymentCard;
    }
}
