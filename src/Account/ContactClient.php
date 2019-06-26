<?php

namespace UKFast\Account;

use UKFast\Page;
use UKFast\Account\Entities\Contact;

class ContactClient extends Client
{
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
}
