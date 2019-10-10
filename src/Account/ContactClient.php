<?php

namespace UKFast\SDK\Account;

use UKFast\SDK\Account\Entities\Contact;
use UKFast\SDK\Client as BaseClient;
use UKFast\SDK\Page;
use UKFast\SDK\SelfResponse;

class ContactClient extends BaseClient
{
    protected $basePath = 'account/';
    
    /**
     * Gets a paginated response of all Contacts
     *
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return Page
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getPage($page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest('v1/contacts', $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return new Contact($item);
        });

        return $page;
    }

    /**
     * Gets an individual contact
     *
     * @param string $id
     * @return Contact
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getById($id)
    {
        $response = $this->request("GET", "v1/contacts/$id");
        $body = $this->decodeJson($response->getBody()->getContents());
        return new Contact($body->data);
    }

    /**
     * @param $contactId
     * @param $currentPassword
     * @param $newPassword
     * @return SelfResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function changePassword($contactId, $currentPassword, $newPassword)
    {
        $payload = [
            'current_password' => $currentPassword,
            'new_password' => $newPassword,
        ];

        $response = $this->patch("v1/contacts/$contactId/password", json_encode($payload));
        $response = $this->decodeJson($response->getBody()->getContents());

        return (new SelfResponse($response))
            ->setClient($this)
            ->serializeWith(function ($response) {
                return new Contact($response);
            });
    }
}
